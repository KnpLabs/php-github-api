<?php

namespace Github\Tests\Api;

use Github\Tests\Api\TestCase;

class DeployKeysTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowKey()
    {
        $expectedValue = array('id' => '12', 'key' => 'ssh-rsa ...');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('user/keys/12')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show(12));
    }

    /**
     * @test
     */
    public function shouldGetKeys()
    {
        $expectedValue = array(array('id' => '12', 'key' => 'ssh-rsa ...'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('user/keys')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    /**
     * @test
     */
    public function shouldCreateKey()
    {
        $expectedValue = array('id' => '123', 'key' => 'ssh-rsa ...');
        $data = array('title' => 'my key', 'key' => 'ssh-rsa ...');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('user/keys', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create($data));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateKeyWithoutTitleParam()
    {
        $data = array('key' => 'ssh-rsa ...');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create($data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateKeyWithoutKeyParam()
    {
        $data = array('title' => 'my key');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create($data);
    }

    /**
     * @test
     */
    public function shouldUpdateKey()
    {
        $expectedValue = array('id' => '123', 'key' => 'ssh-rsa ...');
        $data = array('title' => 'my key', 'key' => 'ssh-rsa ...');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('user/keys/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update(123, $data));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotUpdateKeyWithoutTitleParam()
    {
        $data = array('key' => 'ssh-rsa ...');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update(123, $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotUpdateKeyWithoutKeyParam()
    {
        $data = array('title' => 'my key');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update(123, $data);
    }

    /**
     * @test
     */
    public function shouldRemoveKey()
    {
        $expectedValue = array('some value');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('user/keys/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove(123));
    }

    protected function getApiClass()
    {
        return 'Github\Api\CurrentUser\DeployKeys';
    }
}
