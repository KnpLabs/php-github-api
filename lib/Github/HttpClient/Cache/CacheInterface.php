<?php

namespace Github\HttpClient\Cache;

use Github\HttpClient\Message\Response;

/**
 * Caches github api responses
 *
 * @author     Florian Klein <florian.klein@free.fr>
 */
interface CacheInterface
{
    /**
     * @param  string the id of the cached resource
     * @return int the modified since timestamp
     **/
    public function getModifiedSince($id);

    /**
     * @param  string the id of the cached resource
     * @return Response The cached response object
     **/
    public function get($id);

    /**
     * @param string the id of the cached resource
     * @param Response the response to cache
     **/
    public function set($id, Response $response);
}

