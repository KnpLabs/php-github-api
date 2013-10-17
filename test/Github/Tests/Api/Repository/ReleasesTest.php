<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class ReleasesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllRepositoryReleases()
    {
        $expectedValue = array(array('release1data'), array('release2data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/releases')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetSingleRepositoryRelease()
    {
        $expectedValue = array('releaseData');
        $id = 331;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/releases/'.$id)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', $id));
    }

    /**
     * @test
     */
    public function shouldCreateRepositoryRelease()
    {
        $expectedValue = array('newReleaseData');
        $data = array('tag_name' => '1.1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('repos/KnpLabs/php-github-api/releases')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateRepositoryReleaseWithoutTagName()
    {
        $data = array('not_a_tag_name' => '1.1');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    /**
     * @test
     */
    public function shouldEditRepositoryRelease()
    {
        $expectedValue = array('updatedData');
        $id = 332;
        $data = array('some' => 'thing');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('repos/KnpLabs/php-github-api/releases/'.$id)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->edit('KnpLabs', 'php-github-api', $id, $data));
    }

    /**
     * @test
     */
    public function shouldRemoveRepositoryRelease()
    {
        $expectedValue = array('deleted');
        $id = 333;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('repos/KnpLabs/php-github-api/releases/'.$id)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', $id));
    }

    /**
     * @test
     */
    public function shouldGetAssetsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Assets', $api->assets());
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Releases';
    }
}
