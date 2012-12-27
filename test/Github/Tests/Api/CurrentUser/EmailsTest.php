<?php

namespace Github\Tests\Api;

use Github\Tests\Api\TestCase;

class EmailsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetEmails()
    {
        $expectedValue = array(array('email@example.com'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('user/emails')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all());
    }

    /**
     * @test
     */
    public function shouldRemoveEmail()
    {
        $expectedValue = array('some value');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('user/emails', array('email@example.com'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('email@example.com'));
    }

    /**
     * @test
     */
    public function shouldRemoveEmails()
    {
        $expectedValue = array('some value');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('user/emails', array('email@example.com', 'email2@example.com'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove(array('email@example.com', 'email2@example.com')));
    }

    /**
     * @test
     * @expectedException Github\Exception\InvalidArgumentException
     */
    public function shouldNotRemoveEmailsWhenAreNotPass()
    {
        $api = $this->getApiMock();
        $api->expects($this->any())
            ->method('delete');

        $api->remove(array());
    }

    /**
     * @test
     */
    public function shouldAddEmail()
    {
        $expectedValue = array('some value');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('user/emails', array('email@example.com'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add('email@example.com'));
    }

    /**
     * @test
     */
    public function shouldAddEmails()
    {
        $expectedValue = array('some value');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('user/emails', array('email@example.com', 'email2@example.com'))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->add(array('email@example.com', 'email2@example.com')));
    }

    /**
     * @test
     * @expectedException Github\Exception\InvalidArgumentException
     */
    public function shouldNotAddEmailsWhenAreNotPass()
    {
        $api = $this->getApiMock();
        $api->expects($this->any())
            ->method('post');

        $api->add(array());
    }

    protected function getApiClass()
    {
        return 'Github\Api\CurrentUser\Emails';
    }
}
