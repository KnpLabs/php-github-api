<?php declare(strict_types=1);

namespace Github\Tests\Api;

use Github\Api\GitData\Trees;
use PHPUnit_Framework_MockObject_MockObject;

class TreesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowTreeUsingSha()
    {
        $expectedValue = ['sha' => '123', 'comitter'];

        /** @var Trees|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/git/trees/123', [])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', '123'));
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
                    'sha'  => '1234'
                ],
                [
                    'path' => 'htap',
                    'mode' => 'edom',
                    'type' => 'epyt',
                    'sha'  => '4321'
                ],
            ]
        ];

        /** @var Trees|PHPUnit_Framework_MockObject_MockObject $api */
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
                    'content' => 'content'
                ],
                [
                    'path' => 'htap',
                    'mode' => 'edom',
                    'type' => 'epyt',
                    'content' => 'tnetnoc'
                ],
            ]
        ];

        /** @var Trees|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/git/trees', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWithoutShaAndContentParam()
    {
        $data = [
            'tree' => [
                'path' => 'path',
                'mode' => 'mode',
                'type' => 'type',
            ]
        ];

        /** @var Trees|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWithoutPathParam()
    {
        $data = [
            'tree' => [
                'mode' => 'mode',
                'type' => 'type',
                'content'  => 'content'
            ]
        ];

        /** @var Trees|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWithoutModeParam()
    {
        $data = [
            'tree' => [
                'path' => 'path',
                'type' => 'type',
                'content'  => 'content'
            ]
        ];

        /** @var Trees|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWithoutTypeParam()
    {
        $data = [
            'tree' => [
                'path' => 'path',
                'mode' => 'mode',
                'content'  => 'content'
            ]
        ];

        /** @var Trees|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWithoutTreeParam()
    {
        $data = [];

        /** @var Trees|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWhenTreeParamIsNotArray()
    {
        $data = [
            'tree' => ''
        ];

        /** @var Trees|PHPUnit_Framework_MockObject_MockObject $api */
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    protected function getApiClass(): string
    {
        return Trees::class;
    }
}
