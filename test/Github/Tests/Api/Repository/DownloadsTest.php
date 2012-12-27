<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class DownloadsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryDownloads()
    {
        $expectedValue = array(array('download'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/downloads')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldShowRepositoryDownload()
    {
        $expectedValue = array('download');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/downloads/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'l3l0'));
    }

    /**
     * @test
     */
    public function shouldRemoveRepositoryDownload()
    {
        $expectedValue = 'response';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('repos/KnpLabs/php-github-api/downloads/l3l0')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 'l3l0'));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Downloads';
    }
}
