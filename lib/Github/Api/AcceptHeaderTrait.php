<?php

namespace Github\Api;

/**
 * A trait to make sure we add accept headers on all requests.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
trait AcceptHeaderTrait
{
    protected $acceptHeaderValue = null;

    protected function get($path, array $parameters = array(), array $requestHeaders = array())
    {
        return parent::get($path, $parameters, $this->mergeHeaders($requestHeaders));
    }

    protected function head($path, array $parameters = array(), array $requestHeaders = array())
    {
        return parent::head($path, $parameters, $this->mergeHeaders($requestHeaders));
    }

    protected function post($path, array $parameters = array(), array $requestHeaders = array())
    {
        return parent::post($path, $parameters, $this->mergeHeaders($requestHeaders));
    }

    protected function postRaw($path, $body, array $requestHeaders = array())
    {
        return parent::postRaw($path, $body, $this->mergeHeaders($requestHeaders));
    }

    protected function patch($path, array $parameters = array(), array $requestHeaders = array())
    {
        return parent::patch($path, $parameters, $this->mergeHeaders($requestHeaders));
    }

    protected function put($path, array $parameters = array(), array $requestHeaders = array())
    {
        return parent::put($path, $parameters, $this->mergeHeaders($requestHeaders));
    }

    protected function delete($path, array $parameters = array(), array $requestHeaders = array())
    {
        return parent::delete($path, $parameters, $this->mergeHeaders($requestHeaders));
    }

    /**
     * Append a new accept header on all requests
     * @return array
     */
    private function mergeHeaders(array $headers = array())
    {
        $default = array();
        if ($this->acceptHeaderValue) {
            $default = array('Accept' => $this->acceptHeaderValue);
        }

        return array_merge($default, $headers);
    }
}
