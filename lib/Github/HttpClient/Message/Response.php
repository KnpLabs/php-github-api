<?php

namespace Github\HttpClient\Message;

use Guzzle\Parser\ParserRegistry;
use Guzzle\Http\Message\Response as BaseResponse;

use Github\Exception\ApiLimitExceedException;

class Response extends BaseResponse
{
    /**
     * @var integer
     */
    public $remainingCalls;

    /**
     * Create a new Response based on a raw response message
     *
     * @param string $message Response message
     *
     * @return self|bool Returns false on error
     */
    public static function fromMessage($message)
    {
        $data = ParserRegistry::getInstance()->getParser('message')->parseResponse($message);
        if (!$data) {
            return false;
        }

        $response = new static($data['code'], $data['headers'], $data['body']);
        $response->setProtocol($data['protocol'], $data['version'])
            ->setStatus($data['code'], $data['reason_phrase']);

        // Set the appropriate Content-Length if the one set is inaccurate (e.g. setting to X)
        $contentLength = (string) $response->getHeader('Content-Length');
        $actualLength = strlen($data['body']);
        if (strlen($data['body']) > 0 && $contentLength != $actualLength) {
            $response->setHeader('Content-Length', $actualLength);
        }

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        $response = parent::getBody(true);
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
