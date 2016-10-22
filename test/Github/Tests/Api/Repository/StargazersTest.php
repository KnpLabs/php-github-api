<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class StargazersTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryStargazers()
    {
        $expectedValue = array(array('login' => 'nidup'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/stargazers')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetAllRepositoryStargazersWithAlternativeResponse()
    {
        $expectedValue = array(array('starred_at' => '2013-10-01T13:22:01Z', 'user' => array('login' => 'nidup')));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/stargazers')
            ->will($this->returnValue($expectedValue));
        $api->configure('star');

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Stargazers::class;
    }
}
