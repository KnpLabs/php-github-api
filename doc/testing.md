## Running and writing tests
[Back to the navigation](README.md)


### Run Test Suite

The code is unit tested, there are also some functional tests. To run tests on 
your machine, from a CLI, run

```bash
$ composer update
$ phpunit
```

### Write tests

It is always great if someone wants to contribute and extend the functionality of 
the API client. But all new features must be properly tested. To test a new API 
function, one should test its communication with the HTTP client. The code should 
never make an actual call to Github. Testing could easily be done with mocking. 

If you want to write test for the function that shows you comments to a gist. 

```php
class Comments extends AbstractApi
{
    // ...
    public function show($gist, $comment)
    {
        return $this->get('/gists/'.rawurlencode($gist).'/comments/'.rawurlencode($comment));
    }
}
```

The test will look like this: 

```php
use Github\Tests\Api\TestCase;

class CommentsTest extends TestCase
{
    // ...

    /**
     * @test
     */
    public function shouldShowGistComment()
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
```
