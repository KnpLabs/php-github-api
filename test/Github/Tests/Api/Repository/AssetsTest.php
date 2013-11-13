<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class AssetsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetAllReleaseAssets()
    {
        $expectedValue = array(array('asset1data'), array('asset2data'));
        $id = 76;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/releases/'.$id.'/assets')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', $id));
    }

    /**
     * @test
     */
    public function shouldGetSingleReleaseAsset()
    {
        $expectedValue = array('assetData');
        $assetId = 2;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/releases/assets/'.$assetId)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', $assetId));
    }

    /**
     * @test
     * @requires PHP 5.3.4
     */
    public function shouldCreateReleaseAsset()
    {
        $name = 'asset.gzip';
        $body = 'assetCreatedData';
        $contentType = 'application/gzip';
        $releaseId = '12345';

        $api = $this->getApiMock();
        $api->expects($this->once())
          ->method('postRaw')
          ->with('repos/KnpLabs/php-github-api/releases/'. $releaseId .'/assets?name='.$name)
          ->will($this->returnValue($body));

        $this->assertEquals($body, $api->create('KnpLabs', 'php-github-api', $releaseId, $name, $contentType, $body));
    }

    /**
     * @test
     */
    public function shouldEditReleaseAsset()
    {
        $expectedValue = array('assetUpdatedData');
        $assetId = 5;
        $data = array('name' => 'asset111_name_qweqwe');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('repos/KnpLabs/php-github-api/releases/assets/'.$assetId)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->edit('KnpLabs', 'php-github-api', $assetId, $data));
    }

    /**
     * @test
     * @expectedException Github\Exception\MissingArgumentException
     */
    public function shouldNotEditReleaseAssetWithoutName()
    {
        $assetId = 5;
        $data = array('not_a_name' => 'just a value');

        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('patch');

        $api->edit('KnpLabs', 'php-github-api', $assetId, $data);
    }

    /**
     * @test
     */
    public function shouldRemoveReleaseAsset()
    {
        $expectedValue = array('assetUpdatedData');
        $assetId = 5;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('repos/KnpLabs/php-github-api/releases/assets/'.$assetId)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', $assetId));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Assets';
    }
}
