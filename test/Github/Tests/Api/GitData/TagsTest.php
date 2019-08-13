<?php

namespace Github\Tests\Api\GitData;

use Github\Exception\MissingArgumentException;
use Github\Tests\Api\TestCase;

class TagsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowTagUsingSha()
    {
        $expectedValue = ['sha' => '123', 'comitter'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/git/tags/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldGetAllTags()
    {
        $expectedValue = [['sha' => '123', 'tagger']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/git/refs/tags')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldCreateTag()
    {
        $expectedValue = ['sha' => '123', 'comitter'];
        $data = [
            'message' => 'some message',
            'tag' => 'v2.2',
            'object' => 'test',
            'type' => 'unsigned',
            'tagger' => [
                'name' => 'l3l0',
                'email' => 'leszek.prabucki@gmail.com',
                'date' => date('Y-m-d H:i:s'),
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/git/tags', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldNotCreateTagWithoutMessageParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'tag' => 'v2.2',
            'object' => 'test',
            'type' => 'unsigned',
            'tagger' => [
                'name' => 'l3l0',
                'email' => 'leszek.prabucki@gmail.com',
                'date' => date('Y-m-d H:i:s'),
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldCreateTagWithoutTaggerParam()
    {
        $data = [
            'message' => 'some message',
            'tag' => 'v2.2',
            'object' => 'test',
            'type' => 'unsigned',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateTagWithoutTaggerNameParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'message' => 'some message',
            'tag' => 'v2.2',
            'object' => 'test',
            'type' => 'unsigned',
            'tagger' => [
                'email' => 'leszek.prabucki@gmail.com',
                'date' => date('Y-m-d H:i:s'),
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateTagWithoutTaggerEmailParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'message' => 'some message',
            'tag' => 'v2.2',
            'object' => 'test',
            'type' => 'unsigned',
            'tagger' => [
                'name' => 'l3l0',
                'date' => date('Y-m-d H:i:s'),
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateTagWithoutTaggerDateParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'message' => 'some message',
            'tag' => 'v2.2',
            'object' => 'test',
            'type' => 'unsigned',
            'tagger' => [
                'name' => 'l3l0',
                'email' => 'leszek.prabucki@gmail.com',
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateTagWithoutTagParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'message' => 'some message',
            'object' => 'test',
            'type' => 'unsigned',
            'tagger' => [
                'name' => 'l3l0',
                'email' => 'leszek.prabucki@gmail.com',
                'date' => date('Y-m-d H:i:s'),
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateTagWithoutObjectParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'message' => 'some message',
            'tag' => 'v2.2',
            'type' => 'unsigned',
            'tagger' => [
                'name' => 'l3l0',
                'email' => 'leszek.prabucki@gmail.com',
                'date' => date('Y-m-d H:i:s'),
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateTagWithoutTypeParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'message' => 'some message',
            'tag' => 'v2.2',
            'object' => 'test',
            'tagger' => [
                'name' => 'l3l0',
                'email' => 'leszek.prabucki@gmail.com',
                'date' => date('Y-m-d H:i:s'),
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\GitData\Tags::class;
    }
}
