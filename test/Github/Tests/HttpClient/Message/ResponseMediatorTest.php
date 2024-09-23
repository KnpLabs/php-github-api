<?php

namespace Github\Tests\HttpClient\Message;

use Github\HttpClient\Message\ResponseMediator;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ResponseMediatorTest extends \PHPUnit\Framework\TestCase
{
    public function testGetContent()
    {
        $body = ['foo' => 'bar'];
        $response = new Response(
            200,
            ['Content-Type' => 'application/json'],
            Utils::streamFor(json_encode($body))
        );

        $this->assertEquals($body, ResponseMediator::getContent($response));
    }

    /**
     * If content-type is not json we should get the raw body.
     */
    public function testGetContentNotJson()
    {
        $body = 'foobar';
        $response = new Response(
            200,
            [],
            Utils::streamFor($body)
        );

        $this->assertEquals($body, ResponseMediator::getContent($response));
    }

    /**
     * Make sure we return the body if we have invalid json.
     */
    public function testGetContentInvalidJson()
    {
        $body = 'foobar';
        $response = new Response(
            200,
            ['Content-Type' => 'application/json'],
            Utils::streamFor($body)
        );

        $this->assertEquals($body, ResponseMediator::getContent($response));
    }

    public function testGetPagination()
    {
        $header = '<https://github.com>; rel="first",<https://github.com>; rel="next",<https://github.com>; rel="prev",<https://github.com>; rel="last",';

        $pagination = [
            'first' => 'https://github.com',
            'next' => 'https://github.com',
            'prev' => 'https://github.com',
            'last' => 'https://github.com',
        ];

        // response mock
        $response = new Response(200, ['link' => $header]);
        $result = ResponseMediator::getPagination($response);

        $this->assertEquals($pagination, $result);
    }

    public function testGetHeader()
    {
        $header = 'application/json';
        $response = new Response(
            200,
            ['Content-Type' => $header]
        );

        $this->assertEquals($header, ResponseMediator::getHeader($response, 'content-type'));
    }
}
