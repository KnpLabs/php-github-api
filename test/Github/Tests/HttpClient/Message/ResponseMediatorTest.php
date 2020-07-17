<?php

namespace Github\Tests\HttpClient\Message;

use Github\HttpClient\Message\ResponseMediator;
use GuzzleHttp\Psr7\Response;

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
            ['Content-Type'=>'application/json'],
            \GuzzleHttp\Psr7\stream_for(json_encode($body))
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
            \GuzzleHttp\Psr7\stream_for($body)
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
            ['Content-Type'=>'application/json'],
            \GuzzleHttp\Psr7\stream_for($body)
        );

        $this->assertEquals($body, ResponseMediator::getContent($response));
    }

    public function testGetPagination()
    {
        $header = <<<'TEXT'
<http://github.com>; rel="first",
<http://github.com>; rel="next",
<http://github.com>; rel="prev",
<http://github.com>; rel="last",
TEXT;

        $pagination = [
            'first' => 'http://github.com',
            'next' => 'http://github.com',
            'prev' => 'http://github.com',
            'last' => 'http://github.com',
        ];

        // response mock
        $response = new Response(200, ['link'=>$header]);
        $result = ResponseMediator::getPagination($response);

        $this->assertEquals($pagination, $result);
    }

    public function testGetHeader()
    {
        $header = 'application/json';
        $response = new Response(
            200,
            ['Content-Type'=> $header]
        );

        $this->assertEquals($header, ResponseMediator::getHeader($response, 'content-type'));
    }
}
