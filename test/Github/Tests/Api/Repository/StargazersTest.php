<?php declare(strict_types=1);

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class StargazersTest extends TestCase
{
    public function shouldGetAllRepositoryStargazers()
    {
        $expectedValue = [['login' => 'nidup']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/stargazers')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    public function shouldGetAllRepositoryStargazersWithAlternativeResponse()
    {
        $expectedValue = [['starred_at' => '2013-10-01T13:22:01Z', 'user' => ['login' => 'nidup']]];

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
    protected function getApiClass(): string
    {
        return \Github\Api\Repository\Stargazers::class;
    }
}
