<?php

namespace Github\HttpClient;

use Buzz\Client\ClientInterface;

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
     * @param array                $options
     * @param null|ClientInterface $client
     * @param null|CacheInterface  $cache
     */
    public function __construct(array $options = array(), ClientInterface $client = null, CacheInterface $cache = null)
    {
        parent::__construct($options, $client);

        $this->cache = $cache ?: new FilesystemCache($this->options['cache_dir'] ?: sys_get_temp_dir().DIRECTORY_SEPARATOR.'php-github-api-cache');
    }

    /**
     * {@inheritdoc}
     */
    public function request($path, array $parameters = array(), $httpMethod = 'GET', array $headers = array())
    {
        $response = parent::request($path, $parameters, $httpMethod, $headers);

        $key = trim($this->options['base_url'].$path, '/');
        if ($response->isNotModified()) {
            return $this->cache->get($key);
        }

        $this->cache->set($key, $response);

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
        $request->addHeader(sprintf('If-Modified-Since: %s', date('r', $this->cache->getModifiedSince($url))));

        return $request;
    }
}
