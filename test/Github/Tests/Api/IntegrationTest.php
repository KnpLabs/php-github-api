<?php

namespace Github\Tests\Api;

class IntegrationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldFindRepositoriesForIntegration()
    {
        $result = ['installation1', 'installation2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/integration/installations')
            ->willReturn($result);

        $this->assertEquals($result, $api->findInstallations());
    }

    /**
     * @test
     */
    public function shouldGetRepositoriesFromInstallation()
    {
        $result = ['repo1', 'repo2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/installation/repositories', ['user_id' => '1234'])
            ->willReturn($result);

        $this->assertEquals($result, $api->listRepositories('1234'));
    }

    /**
     * @test
     */
    public function shouldAddRepositoryToInstallation()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/installations/1234/repositories/5678');

        $api->addRepository('1234', '5678');
    }

    /**
     * @test
     */
    public function shouldRemoveRepositoryToInstallation()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/installations/1234/repositories/5678');

        $api->removeRepository('1234', '5678');
    }


    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Integrations::class;
    }
}
