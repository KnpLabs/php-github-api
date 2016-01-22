<?php

namespace spec\Github\HttpClient;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\HttpClient;
use Github\Factory\RequestFactory;

class HttplugClientSpec extends ObjectBehavior
{
    function let(HttpClient $adapter, RequestFactory $factory)
    {
        $this->beConstructedWith($adapter, $factory);
    }

    function it_is_a_http_client()
    {
        $this->shouldBeAnInstanceOf('Github\HttpClient\HttpClientInterface');
    }

    function it_sends_GET_request(
        RequestInterface $request,
        ResponseInterface $response,
        $adapter,
        $factory
    ) {
        $headers = [
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'php-github-api (http://github.com/KnpLabs/php-github-api)',
            'X-Debug-Token' => '13fe23ab',
        ];

        $factory->createRequest('GET', 'https://api.github.com/endpoint?page=1', $headers)->willReturn($request);
        $adapter->sendRequest($request)->willReturn($response);

        $this->get('/endpoint', ['page' => 1], ['X-Debug-Token' => '13fe23ab'])->shouldReturn($response);
    }

    function it_sends_POST_request(
        RequestInterface $request,
        ResponseInterface $response,
        $adapter,
        $factory
    ) {
        $headers = [
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'php-github-api (http://github.com/KnpLabs/php-github-api)',
            'X-Debug-Token' => '13fe23ab',
        ];

        $factory->createRequest('POST', 'https://api.github.com/endpoint', $headers, 'body')->willReturn($request);
        $adapter->sendRequest($request)->willReturn($response);

        $this->post('/endpoint', 'body', ['X-Debug-Token' => '13fe23ab'])->shouldReturn($response);
    }
}
