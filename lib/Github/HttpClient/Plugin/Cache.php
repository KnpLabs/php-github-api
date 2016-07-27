<?php

namespace Github\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Github\HttpClient\Cache\CacheInterface;
use Github\HttpClient\Cache\FilesystemCache;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Performs requests on GitHub API using If-Modified-Since headers.
 * Returns a cached version if not modified
 * Avoids increasing the X-Rate-Limit, which is cool.
 *
 * @author Florian Klein <florian.klein@free.fr>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Cache implements Plugin
{
    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     *
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache = null)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first)
    {
        $cacheKey = sha1($request->getUri()->__toString());

        if ($modifiedAt = $this->getCache()->getModifiedSince($cacheKey)) {
            $modifiedAt = new \DateTime('@'.$modifiedAt);
            $modifiedAt->setTimezone(new \DateTimeZone('GMT'));

            $request = $request->withHeader(
                'If-Modified-Since',
                sprintf('%s GMT', $modifiedAt->format('l, d-M-y H:i:s'))
            );
        }
        if ($etag = $this->getCache()->getETag($cacheKey)) {
            $request = $request->withHeader(
                'If-None-Match',
                $etag
            );
        }

        return $next($request)->then(function (ResponseInterface $response) use ($request, $cacheKey) {
            if (304 === $response->getStatusCode()) {
                $cacheResponse = $this->getCache()->get($cacheKey);
                $this->lastCachedResponse = $cacheResponse;

                return $cacheResponse;
            }

            if (in_array($request->getMethod(), array('GET', 'HEAD'), true)) {
                $this->getCache()->set($cacheKey, $response);
            }

            return $response;
        });
    }


    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        if (null === $this->cache) {
            $this->cache = new FilesystemCache(sys_get_temp_dir().DIRECTORY_SEPARATOR.'php-github-api-cache');
        }

        return $this->cache;
    }
}
