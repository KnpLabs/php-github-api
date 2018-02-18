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
        $expectedValue = [['asset1data'], ['asset2data']];
        $id = 76;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/releases/'.$id.'/assets')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->all('KnpLabs', 'php-github-api', $id));
    }

    /**
     * @test
     */
    public function shouldGetSingleReleaseAsset()
    {
        $expectedValue = ['assetData'];
        $assetId = 2;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/releases/assets/'.$assetId)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', $assetId));
    }

    /**
     * @test
     * @requires PHP 5.3.4
     */
    public function shouldCreateReleaseAsset()
    {
        if (!defined('OPENSSL_TLSEXT_SERVER_NAME') || !OPENSSL_TLSEXT_SERVER_NAME) {
            return $this->markTestSkipped(
                'Asset upload support requires Server Name Indication. This is not supported by your PHP version.'
            );
        }

        $name = 'asset.gzip';
        $body = 'assetCreatedData';
        $contentType = 'application/gzip';
        $releaseId = '12345';

        $api = $this->getApiMock();
        $api->expects($this->once())
          ->method('postRaw')
          ->with('https://uploads.github.com/repos/KnpLabs/php-github-api/releases/'.$releaseId.'/assets?name='.$name)
          ->will($this->returnValue($body));

        $this->assertEquals($body, $api->create('KnpLabs', 'php-github-api', $releaseId, $name, $contentType, $body));
    }

    /**
     * @test
     */
    public function shouldEditReleaseAsset()
    {
        $expectedValue = ['assetUpdatedData'];
        $assetId = 5;
        $data = ['name' => 'asset111_name_qweqwe'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/KnpLabs/php-github-api/releases/assets/'.$assetId)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->edit('KnpLabs', 'php-github-api', $assetId, $data));
    }

    /**
     * @test
     * @expectedException \Github\Exception\MissingArgumentException
     */
    public function shouldNotEditReleaseAssetWithoutName()
    {
        $assetId = 5;
        $data = ['not_a_name' => 'just a value'];

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
        $expectedValue = ['assetUpdatedData'];
        $assetId = 5;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/releases/assets/'.$assetId)
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->remove('KnpLabs', 'php-github-api', $assetId));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repository\Assets::class;
    }
}
