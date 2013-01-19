<?php

namespace Github\HttpClient;

interface ResponseInterface
{
    /**
     * Returns the content of the request deserialized
     *
     * @return array
     */
    public function getContent();

    /**
     * Returns an array of pages
     *
     * @return array|null
     */
    public function getPagination();

    public function getApiLimit();

    /**
     * Return true if the response is not modified
     *
     * @return Boolean
     */
    public function isNotModified();
}
