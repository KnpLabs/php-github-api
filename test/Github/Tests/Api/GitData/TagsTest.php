<?php

namespace Github\Tests\Api;

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
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTagWithoutMessageParam()
    {
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
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTagWithoutTaggerNameParam()
    {
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
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTagWithoutTaggerEmailParam()
    {
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
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTagWithoutTaggerDateParam()
    {
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
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTagWithoutTagParam()
    {
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
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTagWithoutObjectParam()
    {
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
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTagWithoutTypeParam()
    {
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
