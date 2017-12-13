<?php

namespace Github\Tests\Api\Issue;

use Github\Tests\Api\TestCase;

class TimelineTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetIssueEvents()
    {
        $expectedValue = array(
            'event1',
            'event2',
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/123/timeline', array())
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', 123));
    }

    protected function getApiClass(): string
    {
        return \Github\Api\Issue\Timeline::class;
    }
}
