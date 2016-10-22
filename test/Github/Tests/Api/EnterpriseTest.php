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

        $this->assertInstanceOf(\Github\Api\Enterprise\Stats::class, $api->stats());
    }

    /**
     * @test
     */
    public function shouldGetEnterpriseLicenseApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Enterprise\License::class, $api->license());
    }

    /**
     * @test
     */
    public function shouldGetEnterpriseManagementConsoleApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Enterprise\ManagementConsole::class, $api->console());
    }

    /**
     * @test
     */
    public function shouldGetEnterpriseUserAdminApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Enterprise\UserAdmin::class, $api->userAdmin());
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Enterprise::class;
    }
}
