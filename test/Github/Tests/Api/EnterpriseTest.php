<?php

namespace Github\Tests\Api;

class EnterpriseTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetEntepriseStatsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Enterprise\Stats', $api->stats());
    }

    /**
     * @test
     */
    public function shouldGetEnterpriseLicenseApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Enterprise\License', $api->license());
    }

    /**
     * @test
     */
    public function shouldGetEnterpriseManagementConsoleApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Enterprise\ManagementConsole', $api->console());
    }

    /**
     * @test
     */
    public function shouldGetEnterpriseUserAdminApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Enterprise\UserAdmin', $api->userAdmin());
    }

    protected function getApiClass()
    {
        return 'Github\Api\Enterprise';
    }
}
