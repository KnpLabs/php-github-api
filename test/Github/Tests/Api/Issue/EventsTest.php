<?php

namespace Github\Tests\Api\Issue;

use Github\Tests\Api\TestCase;

class EventsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepoIssuesEvents()
    {
        $expectedValue = array(array('event1data'), array('event2data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/issues/events', array('page' => 1))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetIssueEvents()
    {
        $expectedValue = array(array('event1data'), array('event2data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/issues/123/events', array('page' => 1))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @test
     */
    public function shouldShowIssueEvent()
    {
        $expectedValue = array('event1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/issues/events/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Issue\Events';
    }
}
