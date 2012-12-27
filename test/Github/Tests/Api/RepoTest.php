<?php

namespace Github\Tests\Api;

class RepoTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowRepository()
    {
        $expectedArray = array('id' => 1, 'name' => 'repoName');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldSearchRepositories()
    {
        $expectedArray = array(
            array('id' => 1, 'name' => 'php'),
            array('id' => 2, 'name' => 'php-cs')
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('legacy/repos/search/php', array('myparam' => 2, 'start_page' => 1))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('php', array('myparam' => 2)));
    }

    /**
     * @test
     */
    public function shouldPaginateFoundRepositories()
    {
        $expectedArray = array(
            array('id' => 3, 'name' => 'fork of php'),
            array('id' => 4, 'name' => 'fork of php-cs')
        );

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('legacy/repos/search/php', array('start_page' => 2))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('php', array('start_page' => 2)));
    }

    /**
     * @test
     */
    public function shouldCreateRepositoryUsingNameOnly()
    {
        $expectedArray = array('id' => 1, 'name' => 'l3l0Repo');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('user/repos', array('name' => 'l3l0Repo', 'description' => '', 'homepage' => '', 'private' => false))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create('l3l0Repo'));
    }

    /**
     * @test
     */
    public function shouldCreateRepositoryForOrganization()
    {
        $expectedArray = array('id' => 1, 'name' => 'KnpLabsRepo');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('orgs/KnpLabs/repos', array('name' => 'KnpLabsRepo', 'description' => '', 'homepage' => '', 'private' => false))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create('KnpLabsRepo', '', '', true, 'KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryWatchers()
    {
        $expectedArray = array(array('id' => 1, 'username' => 'l3l0'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/watchers', array('page' => 2))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->watchers('KnpLabs', 'php-github-api', 2));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryTags()
    {
        $expectedArray = array(array('sha' => 1234));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/tags')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->tags('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryBranches()
    {
        $expectedArray = array(array('sha' => 1234, 'name' => 'master'));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/branches')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->branches('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryBranch()
    {
        $expectedArray = array('sha' => 1234, 'name' => 'master');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/branches/master')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->branches('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryLanguages()
    {
        $expectedArray = array('lang1', 'lang2');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/languages')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->languages('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetContributorsExcludingAnonymousOnes()
    {
        $expectedArray = array('contrib1', 'contrib2');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/contributors', array('anon' => null))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->contributors('KnpLabs', 'php-github-api', false));
    }

    /**
     * @test
     */
    public function shouldGetContributorsIncludingAnonymousOnes()
    {
        $expectedArray = array('contrib1', 'contrib2');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/contributors', array('anon' => true))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->contributors('KnpLabs', 'php-github-api', true));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryTeams()
    {
        $expectedArray = array(array('id' => 1234), array('id' => 2345));

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('repos/KnpLabs/php-github-api/teams')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->teams('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldCreateUsingAllParams()
    {
        $expectedArray = array('id' => 1, 'name' => 'l3l0Repo');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('user/repos', array('name' => 'l3l0Repo', 'description' => 'test', 'homepage' => 'http://l3l0.eu', 'private' => true))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create('l3l0Repo', 'test', 'http://l3l0.eu', false));
    }

    /**
     * @test
     */
    public function shouldUpdate()
    {
        $expectedArray = array('id' => 1, 'name' => 'l3l0Repo');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('repos/l3l0Repo/test', array('description' => 'test', 'homepage' => 'http://l3l0.eu'))
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('l3l0Repo', 'test', array('description' => 'test', 'homepage' => 'http://l3l0.eu')));
    }

    /**
     * @test
     */
    public function shouldDelete()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('repos/l3l0Repo/test')
            ->will($this->returnValue(null));

        $this->assertNull($api->remove('l3l0Repo', 'test'));
    }

    /**
     * @test
     */
    public function shouldNotDelete()
    {
        $expectedArray = array('message' => 'Not Found');

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('repos/l3l0Repo/uknown-repo')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->remove('l3l0Repo', 'uknown-repo'));
    }

    /**
     * @test
     */
    public function shouldGetCollaboratorsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Collaborators', $api->collaborators());
    }

    /**
     * @test
     */
    public function shouldGetCommentsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Comments', $api->comments());
    }

    /**
     * @test
     */
    public function shouldGetCommitsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Commits', $api->commits());
    }

    /**
     * @test
     */
    public function shouldGetContentsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Contents', $api->contents());
    }

    /**
     * @test
     */
    public function shouldGetDeployKeysApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\DeployKeys', $api->keys());
    }

    /**
     * @test
     */
    public function shouldGetDownloadsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Downloads', $api->downloads());
    }

    /**
     * @test
     */
    public function shouldGetForksApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Forks', $api->forks());
    }

    /**
     * @test
     */
    public function shouldGetHooksApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Hooks', $api->hooks());
    }

    /**
     * @test
     */
    public function shouldGetLabelsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Labels', $api->labels());
    }

    /**
     * @test
     */
    public function shouldGetStatusesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf('Github\Api\Repository\Statuses', $api->statuses());
    }

    protected function getApiClass()
    {
        return 'Github\Api\Repo';
    }
}
