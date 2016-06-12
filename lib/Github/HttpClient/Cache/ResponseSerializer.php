<?php

namespace Github\HttpClient\Cache;

use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\StreamFactory;
use Psr\Http\Message\ResponseInterface;

/**
 * Serialize and unserialize a PSR-7 response.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ResponseSerializer
{
    /**
     * @param ResponseInterface $response
     * @param StreamFactory|null $streamFactory
     *
     * @return array
     */
    public static function serialize(ResponseInterface $response, StreamFactory $streamFactory = null)
    {
        $streamFactory = $streamFactory ?: StreamFactoryDiscovery::find();

        $bodyStream = $response->getBody();
        $body = $bodyStream->__toString();
        if ($bodyStream->isSeekable()) {
            $bodyStream->rewind();
        } else {
            /*
             * If the body is not seekbable we can not rewind it. The stream could be a type of stream
             * that you only can read once. That is why we have to replace the old stream with a new one.
             */
            $response = $response->withBody($streamFactory->createStream($body));
        }

        return serialize(array('response' => serialize($response), 'body' => $body));
    }

    /**
     * @param $data
     * @param StreamFactory|null $streamFactory
     *
     * @return ResponseInterface|null
     */
    public static function unserialize($serializedData, StreamFactory $streamFactory = null)
    {
        $data = unserialize($serializedData);
        if (!isset($data['response']) || !isset($data['body'])) {
            return null;
        }

        $streamFactory = $streamFactory ?: StreamFactoryDiscovery::find();

        $response = unserialize($data['response']);
        $response = $response->withBody($streamFactory->createStream($data['body']));

        return $response;
    }
}
