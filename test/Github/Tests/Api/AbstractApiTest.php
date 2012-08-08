<?php

namespace Github\Tests\Api;

use Github\Api\AbstractApi;

/**
 * AbstractApi test case
 *
 * @author Leszek Prabucki <leszek.prabucki@gmail.com>
 */
class AbstractApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldPassGETRequestToClient()
    {
        $expectedArray = array('value');

        $client = $this->getClientMock();
        $client
            ->expects($this->once())
            ->method('get')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($expectedArray));

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->get('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    /**
     * @test
     */
    public function shouldPassPOSTRequestToClient()
    {
        $expectedArray = array('value');

        $client = $this->getClientMock();
        $client
            ->expects($this->once())
            ->method('post')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($expectedArray));

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->post('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    /**
     * @test
     */
    public function shouldPassPATCHRequestToClient()
    {
        $expectedArray = array('value');

        $client = $this->getClientMock();
        $client
            ->expects($this->once())
            ->method('patch')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($expectedArray));

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->patch('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    /**
     * @test
     */
    public function shouldPassPUTRequestToClient()
    {
        $expectedArray = array('value');

        $client = $this->getClientMock();
        $client
            ->expects($this->once())
            ->method('put')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($expectedArray));

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->put('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    /**
     * @test
     */
    public function shouldPassDELETERequestToClient()
    {
        $expectedArray = array('value');

        $client = $this->getClientMock();
        $client
            ->expects($this->once())
            ->method('delete')
            ->with('/path', array('param1' => 'param1value'), array('option1' => 'option1value'))
            ->will($this->returnValue($expectedArray));

        $api = $this->getAbstractApiObject($client);

        $this->assertEquals($expectedArray, $api->delete('/path', array('param1' => 'param1value'), array('option1' => 'option1value')));
    }

    protected function getAbstractApiObject($client)
    {
        return new AbstractApiTestInstance($client);
    }

    protected function getClientMock()
    {
        return $this->getMockBuilder('Github\Client')
            ->disableOriginalConstructor()
            ->getMock();
    }
}

class AbstractApiTestInstance extends AbstractApi
{
    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), $requestOptions = array())
    {
        return parent::get($path, $parameters, $requestOptions);
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, array $parameters = array(), $requestOptions = array())
    {
        return parent::post($path, $parameters, $requestOptions);
    }

    /**
     * {@inheritDoc}
     */
    public function patch($path, array $parameters = array(), $requestOptions = array())
    {
        return parent::patch($path, $parameters, $requestOptions);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, array $parameters = array(), $requestOptions = array())
    {
        return parent::put($path, $parameters, $requestOptions);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($path, array $parameters = array(), $requestOptions = array())
    {
        return parent::delete($path, $parameters, $requestOptions);
    }
}
