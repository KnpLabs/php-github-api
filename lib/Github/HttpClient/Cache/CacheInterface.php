<?php

namespace Github\HttpClient\Cache;

use Github\HttpClient\ResponseInterface;

/**
 * Caches github api responses
 *
 * @author Florian Klein <florian.klein@free.fr>
 */
interface CacheInterface
{
    /**
     * @param  string $id   The id of the cached resource
     *
     * @return null|integer The modified since timestamp
     */
    public function getModifiedSince($id);

    /**
     * @param  string $id The id of the cached resource
     *
     * @return ResponseInterface   The cached response object
     *
     * @throws \InvalidArgumentException If cache data don't exists
     */
    public function get($id);

    /**
     * @param string            $id       The id of the cached resource
     * @param ResponseInterface $response The response to cache
     *
     * @throws \InvalidArgumentException If cache data cannot be saved
     */
    public function set($id, ResponseInterface $response);
}

