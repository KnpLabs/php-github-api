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
    public function shouldFindInstallationsForApplication()
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
    public function shouldGetInstallationForApplication()
    {
        $result = ['installation1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/app/installations/1234')
            ->willReturn($result);

        $this->assertEquals($result, $api->getInstallation('1234'));
    }

    /**
     * @test
     */
    public function shouldGetInstallationForOrganization()
    {
        $result = ['installation1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/org/1234/installation')
            ->willReturn($result);

        $this->assertEquals($result, $api->getInstallationForOrganization('1234'));
    }

    /**
     * @test
     */
    public function shouldGetInstallationForRepo()
    {
        $result = ['installation1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/MyOrg/MyRepo/installation')
            ->willReturn($result);

        $this->assertEquals($result, $api->getInstallationForRepo('MyOrg', 'MyRepo'));
    }

    /**
     * @test
     */
    public function shouldGetInstallationForUser()
    {
        $result = ['installation1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/users/octocat/installation')
            ->willReturn($result);

        $this->assertEquals($result, $api->getInstallationForUser('octocat'));
    }

    /**
     * @test
     */
    public function shouldDeleteInstallationForApplication()
    {
        $id = 123;
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/app/installations/'.$id);

        $api->removeInstallation($id);
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
