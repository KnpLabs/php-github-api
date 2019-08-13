<?php

namespace Github\Tests\Api\Repository;

use Github\Exception\MissingArgumentException;
use Github\Tests\Api\TestCase;

class DeployKeysTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryDeployKeys()
    {
        $expectedValue = [['name' => 'key']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/keys')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldShowDeployKey()
    {
        $expectedValue = ['key' => 'somename'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/keys/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldRemoveDeployKey()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/keys/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldNotCreateDeployKeyWithoutName()
    {
        $this->expectException(MissingArgumentException::class);
        $data = ['config' => 'conf'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateDeployKeyWithoutColor()
    {
        $this->expectException(MissingArgumentException::class);
        $data = ['name' => 'test'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldCreateDeployKey()
    {
        $expectedValue = ['key' => 'somename'];
        $data = ['title' => 'test', 'key' => 'ssh-rsa 1231234232'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/keys', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldNotUpdateDeployKeyWithoutTitle()
    {
        $this->expectException(MissingArgumentException::class);
        $data = ['key' => 'ssh-rsa 12323213'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('delete');
        $api->expects($this->never())
            ->method('post');

        $api->update('KnpLabs', 'php-github-api', 123, $data);
    }

    /**
     * @test
     */
    public function shouldNotUpdateDeployKeyWithoutKey()
    {
        $this->expectException(MissingArgumentException::class);
        $data = ['title' => 'test'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('delete');
        $api->expects($this->never())
            ->method('post');

        $api->update('KnpLabs', 'php-github-api', 123, $data);
    }

    /**
     * @test
     */
    public function shouldUpdateDeployKey()
    {
        $expectedValue = ['key' => 'somename'];
        $data = ['title' => 'test', 'key' => 'ssh-rsa 12312312321...'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/keys/123')
            ->will($this->returnValue($expectedValue));
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/keys', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\DeployKeys::class;
    }
}
