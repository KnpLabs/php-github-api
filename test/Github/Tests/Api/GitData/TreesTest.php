<?php

namespace Github\Tests\Api\GitData;

use Github\Exception\MissingArgumentException;
use Github\Tests\Api\TestCase;

class TreesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowTreeUsingSha()
    {
        $expectedValue = ['sha' => '123', 'comitter'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/git/trees/123', [])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldCreateTreeUsingSha()
    {
        $expectedValue = ['sha' => '123', 'comitter'];
        $data = [
            'tree' => [
                [
                    'path' => 'path',
                    'mode' => 'mode',
                    'type' => 'type',
                    'sha'  => '1234',
                ],
                [
                    'path' => 'htap',
                    'mode' => 'edom',
                    'type' => 'epyt',
                    'sha'  => '4321',
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/git/trees', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldCreateTreeUsingContent()
    {
        $expectedValue = ['sha' => '123', 'comitter'];
        $data = [
            'tree' => [
                [
                    'path' => 'path',
                    'mode' => 'mode',
                    'type' => 'type',
                    'content' => 'content',
                ],
                [
                    'path' => 'htap',
                    'mode' => 'edom',
                    'type' => 'epyt',
                    'content' => 'tnetnoc',
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/git/trees', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldNotCreateTreeWithoutShaAndContentParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'tree' => [
                'path' => 'path',
                'mode' => 'mode',
                'type' => 'type',
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
    public function shouldNotCreateTreeWithoutPathParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'tree' => [
                'mode' => 'mode',
                'type' => 'type',
                'content'  => 'content',
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
    public function shouldNotCreateTreeWithoutModeParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'tree' => [
                'path' => 'path',
                'type' => 'type',
                'content'  => 'content',
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
    public function shouldNotCreateTreeWithoutTypeParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'tree' => [
                'path' => 'path',
                'mode' => 'mode',
                'content'  => 'content',
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
    public function shouldNotCreateTreeWithoutTreeParam()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldNotCreateTreeWhenTreeParamIsNotArray()
    {
        $this->expectException(MissingArgumentException::class);
        $data = [
            'tree' => '',
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
        return \Github\Api\GitData\Trees::class;
    }
}
