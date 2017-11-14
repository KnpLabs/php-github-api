<?php declare(strict_types=1);

namespace Github\Tests\Api\Issue;

use Github\Tests\Api\TestCase;

class EventsTest extends TestCase
{
    public function shouldGetAllRepoIssuesEvents()
    {
        $expectedValue = array(array('event1data'), array('event2data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/events', array('page' => 1))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    public function shouldGetIssueEvents()
    {
        $expectedValue = array(array('event1data'), array('event2data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/123/events', array('page' => 1))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', 123));
    }

    public function shouldShowIssueEvent()
    {
        $expectedValue = array('event1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/events/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Issue\Events::class;
    }
}
