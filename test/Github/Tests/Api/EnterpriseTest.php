<?php declare(strict_types=1);

namespace Github\Tests\Api;

class EnterpriseTest extends TestCase
{
    public function shouldGetEntepriseStatsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Enterprise\Stats::class, $api->stats());
    }

    public function shouldGetEnterpriseLicenseApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Enterprise\License::class, $api->license());
    }

    public function shouldGetEnterpriseManagementConsoleApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Enterprise\ManagementConsole::class, $api->console());
    }

    public function shouldGetEnterpriseUserAdminApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Enterprise\UserAdmin::class, $api->userAdmin());
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Enterprise::class;
    }
}
