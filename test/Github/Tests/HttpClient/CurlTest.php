<?php

class Github_Tests_HttpClient_CurlTest extends PHPUnit_Framework_TestCase
{
    public function testDoRequest()
    {
        $url       = 'http://site.com/some/path';
        $curlResponse = array('headers' => array('http_code' => 200), 'response' => 'hi there', 'errorNumber' => '', 'errorMessage' => '');
        $options = array('format' => 'text');

        $httpClient = $this->getHttpClientCurlMockBuilder()
            ->setMethods(array('doCurlCall'))
            ->getMock();
        $httpClient->expects($this->once())
            ->method('doCurlCall')
            ->will($this->returnValue($curlResponse));

        $responseText = $httpClient->get($url, array(), $options);

        $this->assertEquals($curlResponse['response'], $responseText);
    }

    public function testDoAuthenticatedRequest()
    {
        $url       = 'http://site.com/some/path';
        $curlResponse = array('headers' => array('http_code' => 200), 'response' => 'hi there', 'errorNumber' => '', 'errorMessage' => '');
        $options = array('format' => 'text', 'login' => 'mylogin', 'secret' => 'mysecret', 'auth_method' => Github_Client::AUTH_URL_TOKEN);

        $httpClient = $this->getHttpClientCurlMockBuilder()
            ->setMethods(array('doCurlCall'))
            ->getMock();
        $httpClient->expects($this->once())
            ->method('doCurlCall')
            ->will($this->returnValue($curlResponse));

        $responseText = $httpClient->get($url, array(), $options);

        $this->assertEquals($curlResponse['response'], $responseText);
    }

    public function testDoGetRequestWithParameters()
    {
        $url       = 'http://site.com/some/path';
        $curlResponse = array('headers' => array('http_code' => 200), 'response' => 'hi there', 'errorNumber' => '', 'errorMessage' => '');
        $params = array('a' => 'b');
        $options = array('format' => 'text');

        $httpClient = $this->getHttpClientCurlMockBuilder()
            ->setMethods(array('doCurlCall'))
            ->getMock();
        $httpClient->expects($this->once())
            ->method('doCurlCall')
            ->will($this->returnValue($curlResponse));

        $responseText = $httpClient->get($url, $params, $options);

        $this->assertEquals($curlResponse['response'], $responseText);
    }

    public function testDoPostRequestWithParameters()
    {
        $url       = 'http://site.com/some/path';
        $curlResponse = array('headers' => array('http_code' => 200), 'response' => 'hi there', 'errorNumber' => '', 'errorMessage' => '');
        $params = array('a' => 'b');
        $options = array('format' => 'text');

        $httpClient = $this->getHttpClientCurlMockBuilder()
            ->setMethods(array('doCurlCall'))
            ->getMock();
        $httpClient->expects($this->once())
            ->method('doCurlCall')
            ->will($this->returnValue($curlResponse));

        $responseText = $httpClient->post($url, $params, $options);

        $this->assertEquals($curlResponse['response'], $responseText);
    }

    protected function getHttpClientCurlMockBuilder()
    {
        return $this->getMockBuilder('Github_HttpClient_Curl');
    }
}
