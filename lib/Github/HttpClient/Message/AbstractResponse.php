<?php

namespace Github\HttpClient\Message;

use Github\Exception\InvalidJsonResponse;
use Github\HttpClient\ResponseInterface;

abstract class AbstractResponse implements ResponseInterface
{
    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        $rawBody = $this->getRawBody();
        $content = json_decode($rawBody, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidJsonResponse($rawBody);
        }

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    public function getPagination()
    {
        $header = $this->getHeaderAsString('Link');
        if (empty($header)) {
            return null;
        }

        $pagination = array();
        foreach (explode(',', $header) as $link) {
            preg_match('/<(.*)>; rel="(.*)"/i', trim($link, ','), $match);

            if (3 === count($match)) {
                $pagination[$match[2]] = $match[1];
            }
        }

        return $pagination;
    }

    /**
     * {@inheritdoc}
     */
    public function isNotModified()
    {
        return 304 === $this->getStatusCode();
    }
}
