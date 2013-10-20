<?php

namespace Github\HttpClient;

interface RequestInterface
{
    /**
     * Returns the adapter request
     */
    public function getAdapterRequest();
}
