<?php

namespace Github\HttpClient;

use Github\HttpClient\Cache\CacheInterface;
use Github\HttpClient\Cache\FilesystemCache;

/**
 * Performs requests on GitHub API using If-Modified-Since headers.
 * Returns a cached version if not modified
 * Avoids increasing the X-Rate-Limit, which is cool
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
        $response = parent::request($path, $body, $httpMethod, $headers, $options);

        if (304 == $response->getStatusCode()) {
            return $this->getCache()->get($path);
        }

        $this->getCache()->set($path, $response);

        return $response;
    }

    /**
     * Create requests with If-Modified-Since headers
     *
     * {@inheritdoc}
     */
    protected function createRequest($httpMethod, $path, $body = null, array $headers = array(), array $options = array())
    {
        $request = parent::createRequest($httpMethod, $path, $body, $headers = array(), $options);

        if ($modifiedAt = $this->getCache()->getModifiedSince($path)) {
            $modifiedAt = new \DateTime('@'.$modifiedAt);
            $modifiedAt->setTimezone(new \DateTimeZone('GMT'));

            $request->addHeader(
                'If-Modified-Since',
                sprintf('%s GMT', $modifiedAt->format('l, d-M-y H:i:s'))
            );
        }
        if ($etag = $this->getCache()->getETag($path)) {
            $request->addHeader(
                'If-None-Match',
                $etag
            );
        }

        return $request;
    }
}
