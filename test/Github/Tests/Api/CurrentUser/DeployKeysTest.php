<?php

namespace Github\Tests\Api;

class DeployKeysTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowKey()
    {
        $expectedValue = ['id' => '12', 'key' => 'ssh-rsa ...'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/keys/12')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show(12));
    }

    /**
     * @test
     */
    public function shouldGetKeys()
    {
        $expectedValue = [['id' => '12', 'key' => 'ssh-rsa ...']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/keys')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    /**
     * @test
     */
    public function shouldCreateKey()
    {
        $expectedValue = ['id' => '123', 'key' => 'ssh-rsa ...'];
        $data = ['title' => 'my key', 'key' => 'ssh-rsa ...'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/user/keys', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create($data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateKeyWithoutTitleParam()
    {
        $data = ['key' => 'ssh-rsa ...'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create($data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateKeyWithoutKeyParam()
    {
        $data = ['title' => 'my key'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create($data);
    }

    /**
     * @test
     */
    public function shouldRemoveKey()
    {
        $expectedValue = ['some value'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/user/keys/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove(123));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\CurrentUser\PublicKeys::class;
    }
}
