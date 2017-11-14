<?php declare(strict_types=1);

namespace Github\Tests\Api;

class EmailsTest extends TestCase
{
    public function shouldGetEmails()
    {
        $expectedValue = [['email@example.com']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/user/emails')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    public function shouldRemoveEmail()
    {
        $expectedValue = ['some value'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/user/emails', ['email@example.com'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('email@example.com'));
    }

    public function shouldRemoveEmails()
    {
        $expectedValue = ['some value'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/user/emails', ['email@example.com', 'email2@example.com'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove(['email@example.com', 'email2@example.com']));
    }

    public function shouldNotRemoveEmailsWhenAreNotPass()
    {
        $api = $this->getApiMock();
        $api->expects($this->any())
            ->method('delete');

        $api->remove([]);
    }

    public function shouldAddEmail()
    {
        $expectedValue = ['some value'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/user/emails', ['email@example.com'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add('email@example.com'));
    }

    public function shouldAddEmails()
    {
        $expectedValue = ['some value'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/user/emails', ['email@example.com', 'email2@example.com'])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add(['email@example.com', 'email2@example.com']));
    }

    public function shouldNotAddEmailsWhenAreNotPass()
    {
        $api = $this->getApiMock();
        $api->expects($this->any())
            ->method('post');

        $api->add([]);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\CurrentUser\Emails::class;
    }
}
