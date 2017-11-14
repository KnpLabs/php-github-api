<?php declare(strict_types=1);

namespace Github\Tests\Api\Organization;

use Github\Tests\Api\TestCase;

class HooksTest extends TestCase
{
    public function shouldGetAllOrganizationsHooks()
    {
        $expectedValue = array(array('name' => 'hook'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/hooks')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs'));
    }

    public function shouldShowHook()
    {
        $expectedValue = array('hook' => 'somename');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/orgs/KnpLabs/hooks/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 123));
    }

    public function shouldRemoveHook()
    {
        $expectedValue = array('someOutput');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/orgs/KnpLabs/hooks/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 123));
    }

    public function shouldNotCreateHookWithoutName()
    {
        $data = array('config' => 'conf');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', $data);
    }

    public function shouldNotCreateHookWithoutConfig()
    {
        $data = array('name' => 'test');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', $data);
    }

    public function shouldCreateHook()
    {
        $expectedValue = array('hook' => 'somename');
        $data = array('name' => 'test', 'config' => 'someconfig');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/orgs/KnpLabs/hooks', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', $data));
    }

    public function shouldNotUpdateHookWithoutConfig()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update('KnpLabs', 123, $data);
    }

    public function shouldUpdateHook()
    {
        $expectedValue = array('hook' => 'somename');
        $data = array('config' => 'config');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/orgs/KnpLabs/hooks/123', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('KnpLabs', 123, $data));
    }

    public function shouldPingHook()
    {
        $expectedValue = null;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/orgs/KnpLabs/hooks/123/pings')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->ping('KnpLabs', 123));
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Organization\Hooks::class;
    }
}
