<?php declare(strict_types=1);

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class DownloadsTest extends TestCase
{
    public function shouldGetAllRepositoryDownloads()
    {
        $expectedValue = [['download']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/downloads')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    public function shouldShowRepositoryDownload()
    {
        $expectedValue = ['download'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/downloads/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'l3l0'));
    }

    public function shouldRemoveRepositoryDownload()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/downloads/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 'l3l0'));
    }

    protected function getApiClass(): string
    {
        return \Github\Api\Repository\Downloads::class;
    }
}
