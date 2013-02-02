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

    /**
     * Return true if the response is not modified
     *
     * @return Boolean
     */
    public function isNotModified();

    /**
     * Returns the value of a header given its name
     *
     * @param string $name
     *
     * @return string
     */
    public function getHeaderAsString($name);

    /**
     * Returns the HTTP status code of the response
     *
     * @return Integer
     */
    public function getStatusCode();

    /**
     * Returns the text body of the response
     *
     * @return string
     */
    public function getRawBody();

    /**
     * Returns the adapter response
     */
    public function getAdapterResponse();
}
