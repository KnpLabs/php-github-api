<?php

namespace Github\Tests\Api\Repository;

use Github\Tests\Api\TestCase;

class ContentsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowContentForGivenPath()
    {
        $expectedValue = '<?php //..';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/contents/test%2FGithub%2FTests%2FApi%2FRepository%2FContentsTest.php', array('ref' => null))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'test/Github/Tests/Api/Repository/ContentsTest.php'));
    }

    /**
     * @test
     */
    public function shouldShowReadme()
    {
        $expectedValue = 'README...';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/readme', array('ref' => null))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->readme('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldFetchTarballArchiveWhenFormatNotRecognized()
    {
        $expectedValue = 'tar';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/tarball', array('ref' => null))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->archive('KnpLabs', 'php-github-api', 'someFormat'));
    }

    /**
     * @test
     */
    public function shouldFetchTarballArchive()
    {
        $expectedValue = 'tar';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/tarball', array('ref' => null))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->archive('KnpLabs', 'php-github-api', 'tarball'));
    }

    /**
     * @test
     */
    public function shouldFetchZipballArchive()
    {
        $expectedValue = 'zip';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/zipball', array('ref' => null))
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->archive('KnpLabs', 'php-github-api', 'zipball'));
    }
    
    /**
     * @test
     */
    public function shouldDownloadForGivenPath()
    {
        // The show() method return
        $getValue = include 'ContentsDownloadFixture.php';
        
        // The download() method return
        $expectedValue = base64_decode($getValue['content']);
        
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/contents/test%2FGithub%2FTests%2FApi%2FRepository%2FContentsTest.php', array('ref' => null))
            ->will($this->returnValue($getValue));

        $this->assertEquals($expectedValue, $api->download('KnpLabs', 'php-github-api', 'test/Github/Tests/Api/Repository/ContentsTest.php'));
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repository\Contents';
    }
}
