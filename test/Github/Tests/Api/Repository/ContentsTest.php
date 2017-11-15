<?php declare(strict_types=1);

namespace Github\Tests\Api\Repository;

use Github\Exception\TwoFactorAuthenticationRequiredException;
use Github\Tests\Api\TestCase;
use GuzzleHttp\Psr7\Response;

class ContentsTest extends TestCase
{
    public function shouldShowContentForGivenPath()
    {
        $expectedValue = '<?php //..';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/contents/test%2FGithub%2FTests%2FApi%2FRepository%2FContentsTest.php', ['ref' => null])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->show('KnpLabs', 'php-github-api', 'test/Github/Tests/Api/Repository/ContentsTest.php'));
    }

    public function shouldShowReadme()
    {
        $expectedValue = 'README...';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/readme', ['ref' => null])
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->readme('KnpLabs', 'php-github-api'));
    }

    public function shouldReturnTrueWhenFileExists()
    {
        $response = new Response(200);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('head')
            ->with('/repos/KnpLabs/php-github-api/contents/composer.json', ['ref' => null])
            ->will($this->returnValue($response));

        $this->assertEquals(true, $api->exists('KnpLabs', 'php-github-api', 'composer.json'));
    }

    public function getFailureStubsForExistsTest()
    {
        $response = new Response(403);

        return [
            [$this->throwException(new \ErrorException())],
            [$this->returnValue($response)]
        ];
    }

    /**
     * @test
     * @dataProvider getFailureStubsForExistsTest
     */
    public function shouldReturnFalseWhenFileIsNotFound(\PHPUnit_Framework_MockObject_Stub $failureStub)
    {
        $expectedValue = ['some-header' => 'value'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('head')
            ->with('/repos/KnpLabs/php-github-api/contents/composer.json', ['ref' => null])
            ->will($failureStub);

        $this->assertFalse($api->exists('KnpLabs', 'php-github-api', 'composer.json'));
    }

    public function shouldBubbleTwoFactorAuthenticationRequiredExceptionsWhenCheckingFileRequiringAuth()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('head')
            ->with('/repos/KnpLabs/php-github-api/contents/composer.json', ['ref' => null])
            ->will($this->throwException(new TwoFactorAuthenticationRequiredException(0)));

        $api->exists('KnpLabs', 'php-github-api', 'composer.json');
    }

    public function shouldCreateNewFile()
    {
        $expectedArray = ['content' => 'some data'];
        $content       = '<?php //..';
        $message       = 'a commit message';
        $branch        = 'master';
        $committer     = ['name' => 'committer name', 'email' => 'email@example.com'];
        $parameters    = [
            'content'   => base64_encode($content),
            'message'   => $message,
            'committer' => $committer,
            'branch'    => $branch,
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/contents/test%2FGithub%2FTests%2FApi%2FRepository%2FContentsTest.php', $parameters)
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create('KnpLabs', 'php-github-api', 'test/Github/Tests/Api/Repository/ContentsTest.php', $content, $message, $branch, $committer));
    }

    public function shouldThrowExceptionWhenCreateNewFileWithInvalidCommitter()
    {
        $committer = ['invalid_key' => 'some data'];
        $api       = $this->getApiMock();
        $api->create('KnpLabs', 'php-github-api', 'test/Github/Tests/Api/Repository/ContentsTest.php', 'some content', 'a commit message', null, $committer);
    }

    public function shouldUpdateFile()
    {
        $expectedArray = ['content' => 'some data'];
        $content       = '<?php //..';
        $message       = 'a commit message';
        $sha           = 'a sha';
        $branch        = 'master';
        $committer     = ['name' => 'committer name', 'email' => 'email@example.com'];
        $parameters    = [
            'content'   => base64_encode($content),
            'message'   => $message,
            'committer' => $committer,
            'branch'    => $branch,
            'sha'       => $sha,
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/contents/test%2FGithub%2FTests%2FApi%2FRepository%2FContentsTest.php', $parameters)
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('KnpLabs', 'php-github-api', 'test/Github/Tests/Api/Repository/ContentsTest.php', $content, $message, $sha, $branch, $committer));
    }

    public function shouldThrowExceptionWhenUpdateFileWithInvalidCommitter()
    {
        $committer = ['invalid_key' => 'some data'];
        $api       = $this->getApiMock();
        $api->update('KnpLabs', 'php-github-api', 'test/Github/Tests/Api/Repository/ContentsTest.php', 'some content', 'a commit message', null, null, $committer);
    }

    public function shouldDeleteFile()
    {
        $expectedArray = ['content' => 'some data'];
        $message       = 'a commit message';
        $sha           = 'a sha';
        $branch        = 'master';
        $committer     = ['name' => 'committer name', 'email' => 'email@example.com'];
        $parameters    = [
            'message'   => $message,
            'committer' => $committer,
            'branch'    => $branch,
            'sha'       => $sha,
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/KnpLabs/php-github-api/contents/test%2FGithub%2FTests%2FApi%2FRepository%2FContentsTest.php', $parameters)
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->rm('KnpLabs', 'php-github-api', 'test/Github/Tests/Api/Repository/ContentsTest.php', $message, $sha, $branch, $committer));
    }

    public function shouldThrowExceptionWhenDeleteFileWithInvalidCommitter()
    {
        $committer = ['invalid_key' => 'some data'];
        $api       = $this->getApiMock();
        $api->rm('KnpLabs', 'php-github-api', 'test/Github/Tests/Api/Repository/ContentsTest.php', 'a commit message', null, null, $committer);
    }

    public function shouldFetchTarballArchiveWhenFormatNotRecognized()
    {
        $expectedValue = 'tar';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/tarball')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->archive('KnpLabs', 'php-github-api', 'someFormat'));
    }

    public function shouldFetchTarballArchive()
    {
        $expectedValue = 'tar';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/tarball')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->archive('KnpLabs', 'php-github-api', 'tarball'));
    }

    public function shouldFetchZipballArchive()
    {
        $expectedValue = 'zip';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/zipball')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->archive('KnpLabs', 'php-github-api', 'zipball'));
    }

    public function shouldFetchZipballArchiveByReference()
    {
        $expectedValue = 'zip';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/zipball/master')
            ->will($this->returnValue($expectedValue));

        $this->assertEquals($expectedValue, $api->archive('KnpLabs', 'php-github-api', 'zipball', 'master'));
    }

    public function shouldDownloadForGivenPath()
    {
        // The show() method return
        $getValue = include __DIR__.'/fixtures/ContentsDownloadFixture.php';

        // The download() method return
        $expectedValue = base64_decode($getValue['content']);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/contents/test%2FGithub%2FTests%2FApi%2FRepository%2FContentsTest.php', ['ref' => null])
            ->will($this->returnValue($getValue));

        $this->assertEquals($expectedValue, $api->download('KnpLabs', 'php-github-api', 'test/Github/Tests/Api/Repository/ContentsTest.php'));
    }

    public function shouldDownloadForSpacedPath()
    {
        // The show() method return
        $getValue = include __DIR__.'/fixtures/ContentsDownloadSpacedFixture.php';

        // The download() method return
        $expectedValue = base64_decode($getValue['content']);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/mads379/scala.tmbundle/contents/Syntaxes%2FSimple%20Build%20Tool.tmLanguage', ['ref' => null])
            ->will($this->returnValue($getValue));

        $this->assertEquals($expectedValue, $api->download('mads379', 'scala.tmbundle', 'Syntaxes/Simple Build Tool.tmLanguage'));
    }

    protected function getApiClass(): string
    {
        return \Github\Api\Repository\Contents::class;
    }
}
