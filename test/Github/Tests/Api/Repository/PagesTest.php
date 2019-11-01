<?php

namespace Github\Tests\Api\Repository;

use Github\Api\Repository\Pages;
use Github\Tests\Api\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class PagesTest.
 *
 * @method Pages|MockObject getApiMock()
 */
class PagesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetPagesInfo()
    {
        $expectedValue = ['status' => 'built'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/pages')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldEnablePages()
    {
        $params = [
            'source' => [
                'branch' => 'master',
                'path'   => '/path',
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/pages', $params);

        $api->enable('KnpLabs', 'php-github-api', $params);
    }

    /**
     * @test
     */
    public function shouldDisablePages()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/pages');

        $api->disable('KnpLabs', 'php-github-api');
    }

    /**
     * @test
     */
    public function shouldUpdatePages()
    {
        $params = [
            'source' => 'master /docs',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/pages', $params);

        $api->update('KnpLabs', 'php-github-api', $params);
    }

    /**
     * @test
     */
    public function shouldRequestPagesBuild()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/pages/builds');

        $api->requestBuild('KnpLabs', 'php-github-api');
    }

    /**
     * @test
     */
    public function shouldGetAllPagesBuilds()
    {
        $expectedValue = [['status' => 'built']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/pages/builds')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->builds('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetLatestPagesBuild()
    {
        $expectedValue = ['status' => 'built'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/pages/builds/latest')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showLatestBuild('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function showGetOnePagesBuild()
    {
        $expectedValue = ['status' => 'built'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/pages/builds/some')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->showBuild('KnpLabs', 'php-github-api', 'some'));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Pages::class;
    }
}
