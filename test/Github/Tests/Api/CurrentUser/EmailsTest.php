<?php

namespace Github\Tests\Api;

class EmailsTest extends TestCase
{
    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     * @expectedException \Github\Exception\InvalidArgumentException
     */
    public function shouldNotRemoveEmailsWhenAreNotPass()
    {
        $api = $this->getApiMock();
        $api->expects($this->any())
            ->method('delete');

        $api->remove([]);
    }

    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     * @expectedException \Github\Exception\InvalidArgumentException
     */
    public function shouldNotAddEmailsWhenAreNotPass()
    {
        $api = $this->getApiMock();
        $api->expects($this->any())
            ->method('post');

        $api->add([]);
    }

    /**
     * @test
     */
    public function shouldToggleVisibility()
    {
        $expectedValue = ['primary email info'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/user/email/visibility')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->toggleVisibility());
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\CurrentUser\Emails::class;
    }
}
