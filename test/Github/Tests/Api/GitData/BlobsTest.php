<?php

namespace Github\Tests\Api;

class BlobsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowBlob()
    {
        $expectedValue = ['blob' => 'some data'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/l3l0/l3l0repo/git/blobs/123456sha')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('l3l0', 'l3l0repo', '123456sha'));
    }

    /**
     * @test
     */
    public function shouldShowRawBlob()
    {
        $expectedValue = ['blob' => 'some data'];

        $client = $this->getMockBuilder('Github\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $api = $this->getMockBuilder($this->getApiClass())
            ->setMethods(['configure', 'get'])
            ->setConstructorArgs([$client])
            ->getMock();
        $api->expects($this->once())
            ->method('configure')
            ->with('raw');
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/l3l0/l3l0repo/git/blobs/123456sha')
            ->will($this->returnValue($expectedValue));

        $api->configure('raw');

        $this->assertEquals($expectedValue, $api->show('l3l0', 'l3l0repo', '123456sha'));
    }

    /**
     * @test
     */
    public function shouldCreateBlob()
    {
        $expectedValue = ['blob' => 'some data'];
        $data = ['content' => 'some cotent', 'encoding' => 'utf8'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/l3l0/l3l0repo/git/blobs', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('l3l0', 'l3l0repo', $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateBlobWithoutEncoding()
    {
        $data = ['content' => 'some cotent'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('l3l0', 'l3l0repo', $data);
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateBlobWithoutContent()
    {
        $data = ['encoding' => 'utf8'];

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('l3l0', 'l3l0repo', $data);
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\GitData\Blobs::class;
    }
}
