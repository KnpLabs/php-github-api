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
        $expectedValue = [
            'event1',
            'event2',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/issues/123/timeline', [])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', 123));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Issue\Timeline::class;
    }
}
