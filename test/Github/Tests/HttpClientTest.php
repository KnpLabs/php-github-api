<?php

class Github_Tests_HttpClientTest extends PHPUnit_Framework_TestCase
{
    public function testInstanciateWithOptions()
    {
        $httpClient = new Github_HttpClient_TestDriver(array(
            'timeout' => 33
        ));

        $this->assertEquals(33, $httpClient->getOption('timeout'));
        $this->assertEquals(80, $httpClient->getOption('http_port'));
    }

    public function testGet()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $httpClient = $this->getHttpClientMockBuilder()
            ->setMethods(array('doRequest', 'request'))
            ->getMock();
        $httpClient->expects($this->once())
            ->method('request')
            ->with($path, $parameters, 'GET', $options);

        $httpClient->get($path, $parameters, $options);
    }

    public function testPost()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $options    = array('c' => 'd');

        $httpClient = $this->getHttpClientMockBuilder()
            ->setMethods(array('doRequest', 'request'))
            ->getMock();
        $httpClient->expects($this->once())
            ->method('request')
            ->with($path, $parameters, 'POST', $options);

        $httpClient->post($path, $parameters, $options);
    }

    public function testRequest()
    {
        $path       = '/some/path';
        $parameters = array('a' => 'b');
        $method     = 'GET';
        $options    = array('c' => 'd');

        $httpClient = $this->getHttpClientMockBuilder()
            ->setMethods(array('doRequest', 'updateHistory', 'decodeResponse'))
            ->getMock();
        $httpClient->expects($this->once())
            ->method('updateHistory')
            ->with();
        $httpClient->expects($this->once())
            ->method('doRequest')
            ->will($this->returnValue('response'));
        $httpClient->expects($this->once())
            ->method('decodeResponse')
            ->with('response')
            ->will($this->returnValue(array('response')));

        $response = $httpClient->request($path, $parameters, $method, $options);

        $this->assertSame(array('response'), $response);
    }

    protected function getHttpClientMockBuilder()
    {
        return $this->getMockBuilder('Github_HttpClient');
    }
}

class Github_HttpClient_TestDriver extends Github_HttpClient
{
    protected function doRequest($url, array $parameters = array(), $httpMethod = 'GET', array $options)
    {
    }

    /**
     * Get an option value.
     *
     * @param  string $name The option name
     *
     * @return mixed  The option value
     */
    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }
}
