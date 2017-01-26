<?php

namespace Github\Tests\Api;

class GraphQLTest extends TestCase
{

    /**
     * @test
     */

    public function shouldTestGraphQL()
    {
        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('/graphql', 'bar')
            ->will($this->returnValue('foo'));

        $result = $api->execute('bar');
        $this->assertEquals('foo', $result);
    }

    protected function getApiClass()
    {
        return \Github\Api\GraphQL::class;
    }
}
