<?php declare(strict_types=1);

namespace Github\Tests\Api;

class DeployKeysTest extends TestCase
{
    public function shouldShowKey()
    {
        $expectedValue = array('id' => '12', 'key' => 'ssh-rsa ...');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/keys/12')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show(12));
    }

    public function shouldGetKeys()
    {
        $expectedValue = array(array('id' => '12', 'key' => 'ssh-rsa ...'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/keys')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    public function shouldCreateKey()
    {
        $expectedValue = array('id' => '123', 'key' => 'ssh-rsa ...');
        $data = array('title' => 'my key', 'key' => 'ssh-rsa ...');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/user/keys', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create($data));
    }

    public function shouldNotCreateKeyWithoutTitleParam()
    {
        $data = array('key' => 'ssh-rsa ...');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create($data);
    }

    public function shouldNotCreateKeyWithoutKeyParam()
    {
        $data = array('title' => 'my key');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create($data);
    }

    public function shouldRemoveKey()
    {
        $expectedValue = array('some value');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/user/keys/123')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove(123));
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\CurrentUser\PublicKeys::class;
    }
}
