<?php declare(strict_types=1);

namespace Github\Tests\Api;

class TreesTest extends TestCase
{
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

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/git/trees', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

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

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/git/trees', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    public function shouldNotCreateTreeWithoutShaAndContentParam()
    {
        $data = [
            'tree' => [
                'path' => 'path',
                'mode' => 'mode',
                'type' => 'type',
            ]
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    public function shouldNotCreateTreeWithoutPathParam()
    {
        $data = [
            'tree' => [
                'mode' => 'mode',
                'type' => 'type',
                'content'  => 'content'
            ]
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    public function shouldNotCreateTreeWithoutModeParam()
    {
        $data = [
            'tree' => [
                'path' => 'path',
                'type' => 'type',
                'content'  => 'content'
            ]
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    public function shouldNotCreateTreeWithoutTypeParam()
    {
        $data = [
            'tree' => [
                'path' => 'path',
                'mode' => 'mode',
                'content'  => 'content'
            ]
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    public function shouldNotCreateTreeWithoutTreeParam()
    {
        $data = [];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    public function shouldNotCreateTreeWhenTreeParamIsNotArray()
    {
        $data = [
            'tree' => ''
        ];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    protected function getApiClass(): string
    {
        return \Github\Api\GitData\Trees::class;
    }
}
