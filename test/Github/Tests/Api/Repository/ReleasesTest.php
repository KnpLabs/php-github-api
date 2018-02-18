<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class ReleasesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetLatestRelease()
    {
        $expectedValue = ['latest_release_data'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/releases/latest')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->latest('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetReleaseByTag()
    {
        $expectedValue = ['latest_release_data'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/releases/tags/5f078080e01e0365690920d618f12342d2c941c8')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->tag(
            'KnpLabs',
            'php-github-api',
            '5f078080e01e0365690920d618f12342d2c941c8'
        ));
    }

    /**
     * @test
     */
    public function shouldGetAllRepositoryReleases()
    {
        $expectedValue = [['release1data'], ['release2data']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/releases')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetSingleRepositoryRelease()
    {
        $expectedValue = ['releaseData'];
        $id = 331;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/releases/'.$id)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', $id));
    }

    /**
     * @test
     */
    public function shouldCreateRepositoryRelease()
    {
        $expectedValue = ['newReleaseData'];
        $data = ['tag_name' => '1.1'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/releases')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotCreateRepositoryReleaseWithoutTagName()
    {
        $data = ['not_a_tag_name' => '1.1'];

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
        $expectedValue = ['updatedData'];
        $id = 332;
        $data = ['some' => 'thing'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/releases/'.$id)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->edit('KnpLabs', 'php-github-api', $id, $data));
    }

    /**
     * @test
     */
    public function shouldRemoveRepositoryRelease()
    {
        $expectedValue = ['deleted'];
        $id = 333;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/releases/'.$id)
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

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Releases::class;
    }
}
