<?php

namespace Github\Tests\Api;

class AuthorizationsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllAuthorizations()
    {
        $expectedArray = array(array('id' => '123'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('authorizations')
            ->will($this->returnValue($expectedArray));

       $this->assertEquals($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldShowAuthorization()
    {
        $id = 123;
        $expectedArray = array('id' => $id);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('authorizations/'.$id)
            ->will($this->returnValue($expectedArray));

       $this->assertEquals($expectedArray, $api->show($id));
    }

    /**
     * @test
     */
    public function shouldCheckAuthorization()
    {
        $id = 123;
        $token = 'abc';
        $expectedArray = array('id' => $id);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('authorizations/'.$id.'/tokens/'.$token)
            ->will($this->returnValue($expectedArray));

       $this->assertEquals($expectedArray, $api->check($id, $token));
    }

    /**
     * @test
     */
    public function shouldAuthorization()
    {
        $input = array(
            'note' => '',
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('authorizations', $input);

        $api->create($input);
    }

    /**
     * @test
     */
    public function shouldUpdateAuthorization()
    {
        $id = 123;
        $input = array(
            'note' => '',
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('authorizations/'.$id, $input);

        $api->update($id, $input);
    }

    /**
     * @test
     */
    public function shouldDeleteAuthorization()
    {
        $id = 123;
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('authorizations/'.$id);

        $api->remove($id);
    }

    protected function getApiClass()
    {
        return 'Github\Api\Authorizations';
    }
}
