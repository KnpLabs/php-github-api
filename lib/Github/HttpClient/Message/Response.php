<?php

namespace Github\HttpClient\Message;

use Buzz\Message\Response as BaseResponse;
use Github\Exception\ApiLimitExceedException;

class Response extends BaseResponse
{
    /**
     * @var integer
     */
    public $remainingCalls;

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        $response = parent::getContent();
        $content  = json_decode($response, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return $response;
        }

        return $content;
    }

    /**
     * @return array|null
     */
    public function getPagination()
    {
        $header = $this->getHeader('Link');
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
     * {@inheritDoc}
     */
    public function getApiLimit()
    {
        $header = $this->getHeader('X-RateLimit-Remaining');
        if (!empty($header)) {
            $this->remainingCalls = $header;
        }

        if (null !== $this->remainingCalls && 1 > $this->remainingCalls) {
            throw new ApiLimitExceedException($this->getHeader('X-RateLimit-Limit'));
        }
    }
}
