<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class StatusesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowCommitStatuses()
    {
        $expectedValue = array(
            array('state' => 'success', 'context' => 'Travis'),
            array('state' => 'pending', 'context' => 'Travis')
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/commits/commitSHA123456/statuses')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'commitSHA123456'));
    }

    /**
     * @test
     */
    public function shouldShowCombinedCommitStatuses()
    {
        $expectedValue = array(
            array(
                'state' => 'success',
                'statuses' => array(
                    array(
                        'state' => 'success',
                        'context' => 'Travis'
                    ),
                    array(
                        'state' => 'success',
                        'context' => 'Jenkins'
                    )
                )
            )
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/commits/commitSHA123456/status')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->combined('KnpLabs', 'php-github-api', 'commitSHA123456'));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateWithoutStatus()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', 'commitSHA123456', $data);
    }

    /**
     * @test 
     */
    public function shouldCreateCommitStatus()
    {
        $expectedValue = array('state' => 'success');
        $data = array('state' => 'success');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/KnpLabs/php-github-api/statuses/commitSHA123456', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', 'commitSHA123456', $data));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Statuses';
    }
}
