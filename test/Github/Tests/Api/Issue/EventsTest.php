<?php declare(strict_types=1);

namespace Github\Tests\Api\Issue;

use Github\Tests\Api\TestCase;

class EventsTest extends TestCase
{
    public function shouldGetAllRepoIssuesEvents()
    {
        $expectedValue = [['event1data'], ['event2data']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/events', ['page' => 1])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    public function shouldGetIssueEvents()
    {
        $expectedValue = [['event1data'], ['event2data']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/123/events', ['page' => 1])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', 123));
    }

    public function shouldShowIssueEvent()
    {
        $expectedValue = ['event1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/events/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 123));
    }

    protected function getApiClass(): string
    {
        return \Github\Api\Issue\Events::class;
    }
}
