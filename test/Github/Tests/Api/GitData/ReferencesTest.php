<?php

namespace Github\Tests\Api;

use Github\Tests\Api\TestCase;

class ReferencesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowReference()
    {
        $expectedValue = array('reference' => 'some data');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/l3l0/l3l0repo/git/refs/123456sha')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('l3l0', 'l3l0repo', '123456sha'));
    }

    /**
     * @test
     */
    public function shouldRemoveReference()
    {
        $expectedValue = array('reference' => 'some data');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('repos/l3l0/l3l0repo/git/refs/123456sha')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('l3l0', 'l3l0repo', '123456sha'));
    }

    /**
     * @test
     */
    public function shouldGetAllRepoReferences()
    {
        $expectedValue = array(array('reference' => 'some data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/l3l0/l3l0repo/git/refs')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('l3l0', 'l3l0repo'));
    }

    /**
     * @test
     */
    public function shouldGetAllRepoBranches()
    {
        $expectedValue = array(array('branch' => 'some data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/l3l0/l3l0repo/git/refs/heads')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->branches('l3l0', 'l3l0repo'));
    }

    /**
     * @test
     */
    public function shouldGetAllRepoTags()
    {
        $expectedValue = array(array('tag' => 'some data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/l3l0/l3l0repo/git/refs/tags')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->tags('l3l0', 'l3l0repo'));
    }

    /**
     * @test
     */
    public function shouldCreateReference()
    {
        $expectedValue = array('reference' => 'some data');
        $data = array('ref' => '122', 'sha' => '1234');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/l3l0/l3l0repo/git/refs', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('l3l0', 'l3l0repo', $data));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateReferenceWithoutShaParam()
    {
        $data = array('ref' => '123');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('l3l0', 'l3l0repo', $data);
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateReferenceWithoutRefsParam()
    {
        $data = array('sha' => '1234');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('l3l0', 'l3l0repo', $data);
    }

    /**
     * @test
     */
    public function shouldUpdateReference()
    {
        $expectedValue = array('reference' => 'some data');
        $data = array('sha' => '12345sha');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('repos/l3l0/l3l0repo/git/refs/someRefs', $data)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->update('l3l0', 'l3l0repo', 'someRefs', $data));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNoUpdateReferenceWithoutSha()
    {
        $data = array();

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->update('l3l0', 'l3l0repo', 'someRefs', $data);
    }

    protected function getApiClass()
    {
        return 'Github\Api\GitData\References';
    }
}
