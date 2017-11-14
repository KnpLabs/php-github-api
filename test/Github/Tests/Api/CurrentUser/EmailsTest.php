<?php declare(strict_types=1);

namespace Github\Tests\Api;

class EmailsTest extends TestCase
{
    public function shouldGetEmails()
    {
        $expectedValue = array(array('email@example.com'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/emails')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    public function shouldRemoveEmail()
    {
        $expectedValue = array('some value');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/user/emails', array('email@example.com'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('email@example.com'));
    }

    public function shouldRemoveEmails()
    {
        $expectedValue = array('some value');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/user/emails', array('email@example.com', 'email2@example.com'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove(array('email@example.com', 'email2@example.com')));
    }

    public function shouldNotRemoveEmailsWhenAreNotPass()
    {
        $api = $this->getApiMock();
        $api->expects($this->any())
            ->method('delete');

        $api->remove(array());
    }

    public function shouldAddEmail()
    {
        $expectedValue = array('some value');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/user/emails', array('email@example.com'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add('email@example.com'));
    }

    public function shouldAddEmails()
    {
        $expectedValue = array('some value');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/user/emails', array('email@example.com', 'email2@example.com'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add(array('email@example.com', 'email2@example.com')));
    }

    public function shouldNotAddEmailsWhenAreNotPass()
    {
        $api = $this->getApiMock();
        $api->expects($this->any())
            ->method('post');

        $api->add(array());
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\CurrentUser\Emails::class;
    }
}
