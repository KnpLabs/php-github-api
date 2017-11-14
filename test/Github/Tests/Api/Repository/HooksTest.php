<?php declare(strict_types=1);

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class HooksTest extends TestCase
{
    public function shouldGetAllRepositoryHooks()
    {
        $expectedValue = [['name' => 'hook']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/hooks')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    public function shouldShowHook()
    {
        $expectedValue = ['hook' => 'somename'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/hooks/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    public function shouldRemoveHook()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/hooks/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 123));
    }

    public function shouldNotCreateHookWithoutName()
    {
        $data = ['config' => 'conf'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    public function shouldNotCreateHookWithoutColor()
    {
        $data = ['name' => 'test'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    public function shouldCreateHook()
    {
        $expectedValue = ['hook' => 'somename'];
        $data = ['name' => 'test', 'config' => 'someconfig'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/hooks', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    public function shouldNotUpdateHookWithoutConfig()
    {
        $data = ['name' => 'test'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update('KnpLabs', 'php-github-api', 123, $data);
    }

    public function shouldUpdateHook()
    {
        $expectedValue = ['hook' => 'somename'];
        $data = ['name' => 'test', 'config' => 'config'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/hooks/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 'php-github-api', 123, $data));
    }

    public function shouldTestHook()
    {
        $expectedValue = [['name' => 'hook']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/hooks/123/test')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->test('KnpLabs', 'php-github-api', 123));
    }

    protected function getApiClass(): string
    {
        return \Github\Api\Repository\Hooks::class;
    }
}
