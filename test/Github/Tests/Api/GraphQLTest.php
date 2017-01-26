class GraphQLTest extends TestCase
{
    // ...

    /**
     * @test
     */
    public function shouldShowGistComment()
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
