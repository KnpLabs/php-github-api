<?php declare(strict_types=1);

namespace Github\Tests\Api;

use Github\Api\Apps;
use PHPUnit_Framework_MockObject_MockObject;

class AppTest extends TestCase
{
    /**
     * @test
     */
    public function shouldFindRepositoriesForApplication()
    {
        $result = ['installation1', 'installation2'];

        /** @var Apps|PHPUnit_Framework_MockObject_MockObject $api */
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

        /** @var Apps|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/installation/repositories', ['user_id' => '1234'])
            ->willReturn($result);

        $this->assertEquals($result, $api->listRepositories(1234));
    }

    /**
     * @test
     */
    public function shouldAddRepositoryToInstallation()
    {
        /** @var Apps|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/installations/1234/repositories/5678');

        $api->addRepository(1234, 5678);
    }

    /**
     * @test
     */
    public function shouldRemoveRepositoryToInstallation()
    {
        /** @var Apps|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/installations/1234/repositories/5678');

        $api->removeRepository(1234, 5678);
    }


    protected function getApiClass(): string
    {
        return \Github\Api\Apps::class;
    }
}
