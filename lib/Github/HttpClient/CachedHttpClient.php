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
    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array())
    {
        $response = parent::request($path, $parameters, $httpMethod, $headers);

        $key = trim($this->options['base_url'].$path, '/');
        if (304 == $response->getStatusCode()) {
            return $this->getCache()->get($key);
        }

        $this->getCache()->set($key, $response);

        return $response;
    }

    /**
     * Create requests with If-Modified-Since headers
     *
     * {@inheritdoc}
     */
    protected function createRequest($httpMethod, $url)
    {
        $request = parent::createRequest($httpMethod, $url);

        if ($modifiedAt = $this->getCache()->getModifiedSince($url)) {
            $modifiedAt = new \DateTime('@'.$modifiedAt);
            $modifiedAt->setTimezone(new \DateTimeZone('GMT'));

            $request->addHeader(sprintf('If-Modified-Since: %s GMT', $modifiedAt->format('l, d-M-y H:i:s')));
        }

        return $request;
    }
}
