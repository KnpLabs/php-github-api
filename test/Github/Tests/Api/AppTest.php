<?php declare(strict_types=1);

namespace Github\Tests\Api;

class AppTest extends TestCase
{
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

    public function shouldAddRepositoryToInstallation()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/installations/1234/repositories/5678');

        $api->addRepository('1234', '5678');
    }

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
    protected function getApiClass(): string
    {
        return \Github\Api\Apps::class;
    }
}
