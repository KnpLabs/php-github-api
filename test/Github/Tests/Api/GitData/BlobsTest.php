<?php declare(strict_types=1);

namespace Github\Tests\Api;

class BlobsTest extends TestCase
{
    public function shouldShowBlob()
    {
        $expectedValue = array('blob' => 'some data');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/l3l0/l3l0repo/git/blobs/123456sha')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('l3l0', 'l3l0repo', '123456sha'));
    }

    public function shouldShowRawBlob()
    {
        $expectedValue = array('blob' => 'some data');

        $client = $this->getMockBuilder('Github\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $api = $this->getMockBuilder($this->getApiClass())
            ->setMethods(array('configure', 'get'))
            ->setConstructorArgs(array($client))
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

    public function shouldCreateBlob()
    {
        $expectedValue = array('blob' => 'some data');
        $data = array('content' => 'some cotent', 'encoding' => 'utf8');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/l3l0/l3l0repo/git/blobs', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('l3l0', 'l3l0repo', $data));
    }

    public function shouldNotCreateBlobWithoutEncoding()
    {
        $data = array('content' => 'some cotent');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('l3l0', 'l3l0repo', $data);
    }

    public function shouldNotCreateBlobWithoutContent()
    {
        $data = array('encoding' => 'utf8');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('l3l0', 'l3l0repo', $data);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\GitData\Blobs::class;
    }
}
