<?php declare(strict_types=1);

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
            ->with($this->equalTo('/graphql'), $this->equalTo(['query'=>'bar']))
            ->will($this->returnValue('foo'));

        $result = $api->execute('bar');
        $this->assertEquals('foo', $result);
    }

    /**
     * @test
     */
    public function shouldSupportGraphQLVariables()
    {
        $api = $this->getApiMock();

        $api->method('post')
            ->with('/graphql', $this->arrayHasKey('variables'));

        $api->execute('bar', ['variable' => 'foo']);
    }

    /**
     * @test
     */
    public function shouldJSONEncodeGraphQLVariables()
    {
        $api = $this->getApiMock();

        $api->method('post')
            ->with('/graphql', $this->equalTo([
                'query'=>'bar',
                'variables' => '{"variable":"foo"}'
            ]));

        $api->execute('bar', ['variable' => 'foo']);
    }

    protected function getApiClass(): string
    {
        return \Github\Api\GraphQL::class;
    }
}
