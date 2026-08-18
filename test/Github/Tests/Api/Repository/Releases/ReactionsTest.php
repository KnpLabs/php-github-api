<?php

namespace Github\Tests\Api\Repository\Releases;

use Github\Exception\MissingArgumentException;
use Github\Tests\Api\TestCase;

class ReactionsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllReleaseReactions()
    {
        $expectedValue = [['reaction1data'], ['reaction2data']];
        $parameters = ['content' => 'laugh'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/releases/123/reactions', $parameters)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', 123, $parameters));
    }

    /**
     * @test
     */
    public function shouldNotCreateReleaseReactionWithoutContent()
    {
        $this->expectException(MissingArgumentException::class);

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', 123, []);
    }

    /**
     * @test
     */
    public function shouldCreateReleaseReaction()
    {
        $expectedValue = ['reaction1data'];
        $data = ['content' => 'laugh'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/releases/123/reactions', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', 123, $data));
    }

    /**
     * @test
     */
    public function shouldRemoveReleaseReaction()
    {
        $expectedValue = ['someOutput'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/releases/123/reactions/456')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', 123, 456));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Releases\Reactions::class;
    }
}
