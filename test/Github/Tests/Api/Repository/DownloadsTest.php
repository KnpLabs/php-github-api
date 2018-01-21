<?php declare(strict_types=1);

namespace Github\Tests\Api\Repository;

use Github\Api\Repository\Downloads;
use Github\Tests\Api\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

class DownloadsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryDownloads()
    {
        $expectedValue = [['download']];

        /** @var Downloads|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/downloads')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldShowRepositoryDownload()
    {
        $expectedValue = ['download'];

        /** @var Downloads|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/downloads/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'l3l0'));
    }

    /**
     * @test
     */
    public function shouldRemoveRepositoryDownload()
    {
        $expectedValue = 'response';

        /** @var Downloads|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/downloads/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 'l3l0'));
    }

    protected function getApiClass(): string
    {
        return Downloads::class;
    }
}
