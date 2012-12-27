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
        $expectedValue = array(array('name' => 'l3l0repo'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/forks', array('page' => 1))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldCreateFork()
    {
        $expectedValue = array(array('name' => 'l3l0repo'));
        $data = array('someparam');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/KnpLabs/php-github-api/forks', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldSortByNewestWhenSortParamNotRecognized()
    {
        $expectedValue = array(array('name' => 'l3l0repo'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/forks', array('page' => 1, 'sort' => 'newest'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', array('sort' => 'oldes')));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Forks';
    }
}
