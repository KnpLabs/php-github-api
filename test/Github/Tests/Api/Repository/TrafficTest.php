<?php

use Github\Tests\Api\TestCase;

class TrafficTest extends TestCase
{
    // ...

    /**
     * @test
     */
    public function shoulddoSomething()
    {
        // Create a variable with the "Server response".
        $expectedValue = array('comment1');

        // Get the API mock (see "getApiClass" below).
        $api = $this->getApiMock();

        $api->expects($this->once())                    // Expect one call
            ->method('get')                             // A GET request
            ->with('/gists/123/comments/456')           // URI should be "/gists/123/comments/456"
            ->will($this->returnValue($expectedValue)); // Should return the "Server response"

        // Call Comments::show
        $result = $api->show(123, 456);

        // Verify that the result is the "Server response" as we expect. 
        $this->assertEquals($expectedValue, $result);
    }

    protected function getApiClass()
    {
        // Tell the "getAPIMock" what class to mock. 
        return \Github\Api\Gist\Comments::class;
    }
}
