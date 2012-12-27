<?php

namespace Github\Tests\Api;

use Github\Tests\Api\TestCase;

class TreesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowTreeUsingSha()
    {
        $expectedValue = array('sha' => '123', 'comitter');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/git/trees/123', array('recursive' => null))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldCreateTreeUsingSha()
    {
        $expectedValue = array('sha' => '123', 'comitter');
        $data = array(
            'tree' => array(
                array(
                    'path' => 'path',
                    'mode' => 'mode',
                    'type' => 'type',
                    'sha'  => '1234'
                ),
                array(
                    'path' => 'htap',
                    'mode' => 'edom',
                    'type' => 'epyt',
                    'sha'  => '4321'
                ),
            )
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/KnpLabs/php-github-api/git/trees', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     */
    public function shouldCreateTreeUsingContent()
    {
        $expectedValue = array('sha' => '123', 'comitter');
        $data = array(
            'tree' => array(
                array(
                    'path' => 'path',
                    'mode' => 'mode',
                    'type' => 'type',
                    'content' => 'content'
                ),
                array(
                    'path' => 'htap',
                    'mode' => 'edom',
                    'type' => 'epyt',
                    'content' => 'tnetnoc'
                ),
            )
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/KnpLabs/php-github-api/git/trees', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWithoutShaAndContentParam()
    {
        $data = array(
            'tree' => array(
                'path' => 'path',
                'mode' => 'mode',
                'type' => 'type',
            )
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWithoutPathParam()
    {
        $data = array(
            'tree' => array(
                'mode' => 'mode',
                'type' => 'type',
                'content'  => 'content'
            )
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWithoutModeParam()
    {
        $data = array(
            'tree' => array(
                'path' => 'path',
                'type' => 'type',
                'content'  => 'content'
            )
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWithoutTypeParam()
    {
        $data = array(
            'tree' => array(
                'path' => 'path',
                'mode' => 'mode',
                'content'  => 'content'
            )
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWithoutTreeParam()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateTreeWhenTreeParamIsNotArray()
    {
        $data = array(
            'tree' => ''
        );

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    protected function getApiClass()
    {
        return 'Github\Api\GitData\Trees';
    }
}
