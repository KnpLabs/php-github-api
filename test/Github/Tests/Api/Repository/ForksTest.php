<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class ForksTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetForks()
    {
        $expectedValue = [['name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/forks', ['page' => 1])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldCreateFork()
    {
        $expectedValue = [['name' => 'l3l0repo']];
        $data = ['someparam'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/forks', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldSortByNewestWhenSortParamNotRecognized()
    {
        $expectedValue = [['name' => 'l3l0repo']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/forks', ['page' => 1, 'sort' => 'newest'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', ['sort' => 'oldes']));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Forks::class;
    }
}
