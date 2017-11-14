<?php declare(strict_types=1);

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class ReleasesTest extends TestCase
{
    public function shouldGetLatestRelease()
    {
        $expectedValue = array('latest_release_data');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/releases/latest')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->latest('KnpLabs', 'php-github-api'));
    }

    public function shouldGetReleaseByTag()
    {
        $expectedValue = array('latest_release_data');

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

    public function shouldGetAllRepositoryReleases()
    {
        $expectedValue = array(array('release1data'), array('release2data'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/releases')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api'));
    }

    public function shouldGetSingleRepositoryRelease()
    {
        $expectedValue = array('releaseData');
        $id = 331;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/releases/'.$id)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', $id));
    }

    public function shouldCreateRepositoryRelease()
    {
        $expectedValue = array('newReleaseData');
        $data = array('tag_name' => '1.1');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/releases')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->create('KnpLabs', 'php-github-api', $data));
    }

    public function shouldNotCreateRepositoryReleaseWithoutTagName()
    {
        $data = array('not_a_tag_name' => '1.1');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('post');

        $api->create('KnpLabs', 'php-github-api', $data);
    }

    public function shouldEditRepositoryRelease()
    {
        $expectedValue = array('updatedData');
        $id = 332;
        $data = array('some' => 'thing');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/releases/'.$id)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->edit('KnpLabs', 'php-github-api', $id, $data));
    }

    public function shouldRemoveRepositoryRelease()
    {
        $expectedValue = array('deleted');
        $id = 333;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/releases/'.$id)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', $id));
    }

    public function shouldGetAssetsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Assets', $api->assets());
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return \Github\Api\Repository\Releases::class;
    }
}
