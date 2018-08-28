<?php

namespace Github\Tests\Api;

class AppTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateInstallationTokenForInstallation()
    {
        $result = [
            'token' => 'v1.1f699f1069f60xxx',
            'expires_at' => '2016-07-11T22:14:10Z',
        ];
        $installationId = 'installation1';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/app/installations/'.$installationId.'/access_tokens', [])
            ->willReturn($result);

        $this->assertEquals($result, $api->createInstallationToken($installationId));
    }

    /**
     * @test
     */
    public function shouldFindRepositoriesForApplication()
    {
        $result = ['installation1', 'installation2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/app/installations')
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
        return \Github\Api\Apps::class;
    }
}
