<?php

namespace Github\HttpClient;

use Github\HttpClient\Cache\CacheInterface;
use Github\HttpClient\Cache\FilesystemCache;

/**
 * Performs requests on GitHub API using If-Modified-Since headers.
 * Returns a cached version if not modified
 * Avoids increasing the X-Rate-Limit, which is cool.
 *
 * @author Florian Klein <florian.klein@free.fr>
 */
class CachedHttpClient extends HttpClient
{
    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * Contains the lastResponse fetched from cache.
     *
     * @var Guzzle\Http\Message\Response
     */
    private $lastCachedResponse;

    /**
     * $path + query parameter(s) if they exist.
     *
     * @var string
     */
    private $path;

    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        if (null === $this->cache) {
            $this->cache = new FilesystemCache($this->options['cache_dir'] ?: sys_get_temp_dir().DIRECTORY_SEPARATOR.'php-github-api-cache');
        }

        return $this->cache;
    }

    /**
     * @param $cache CacheInterface
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function request($path, $body = null, $httpMethod = 'GET', array $headers = array(), array $options = array())
    {
        $this->formatPath($path, $options);

        $response = parent::request($path, $body, $httpMethod, $headers, $options);

        if (304 == $response->getStatusCode()) {
            $cacheResponse = $this->getCache()->get($this->path);
            $this->lastCachedResponse = $cacheResponse;

            return $cacheResponse;
        }

        $this->getCache()->set($this->path, $response);

        return $response;
    }

    /**
     * Create requests with If-Modified-Since headers.
     *
     * {@inheritdoc}
     */
    protected function createRequest($httpMethod, $path, $body = null, array $headers = array(), array $options = array())
    {
        $request = parent::createRequest($httpMethod, $path, $body, $headers, $options);

        if ($modifiedAt = $this->getCache()->getModifiedSince($this->path)) {
            $modifiedAt = new \DateTime('@'.$modifiedAt);
            $modifiedAt->setTimezone(new \DateTimeZone('GMT'));

            $request->addHeader(
                'If-Modified-Since',
                sprintf('%s GMT', $modifiedAt->format('l, d-M-y H:i:s'))
            );
        }
        if ($etag = $this->getCache()->getETag($this->path)) {
            $request->addHeader(
                'If-None-Match',
                $etag
            );
        }

        return $request;
    }

    /**
     * @return Guzzle\Http\Message\Response
     */
    public function getLastResponse($force = false)
    {
        $lastResponse =  parent::getLastResponse();
        if (304 != $lastResponse->getStatusCode()) {
            $force = true;
        }

        return ($force) ? $lastResponse : $this->lastCachedResponse;
    }

    /**
     * Format the path and add query parameters if they exist.
     *
     * @param string $path
     * @param array  $options
     * @return void
     */
    private function formatPath($path, array $options)
    {
        $this->path = $path;

        if (array_key_exists('query', $options) && !empty($options['query'])) {
            $this->path .= '?';

            $i = 0;
            foreach ($options['query'] as $key => $value) {
                if ($i > 0) {
                    $this->path .= '&';
                }

                $this->path .= $key . '=' . $value;

                $i++;
            }
        }
    }
}
