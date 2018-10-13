<?php

namespace Github\Tests\Api;

class RepoTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowRepository()
    {
        $expectedArray = ['id' => 1, 'name' => 'repoName'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldShowRepositoryById()
    {
        $expectedArray = ['id' => 123456, 'name' => 'repoName'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repositories/123456')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->showById(123456));
    }

    /**
     * @test
     */
    public function shouldSearchRepositories()
    {
        $expectedArray = [
            ['id' => 1, 'name' => 'php'],
            ['id' => 2, 'name' => 'php-cs'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/legacy/repos/search/php', ['myparam' => 2, 'start_page' => 1])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('php', ['myparam' => 2]));
    }

    /**
     * @test
     */
    public function shouldPaginateFoundRepositories()
    {
        $expectedArray = [
            ['id' => 3, 'name' => 'fork of php'],
            ['id' => 4, 'name' => 'fork of php-cs'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/legacy/repos/search/php', ['start_page' => 2])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->find('php', ['start_page' => 2]));
    }

    /**
     * @test
     */
    public function shouldGetAllRepositories()
    {
        $expectedArray = [
            ['id' => 1, 'name' => 'dummy project'],
            ['id' => 2, 'name' => 'awesome another project'],
            ['id' => 3, 'name' => 'fork of php'],
            ['id' => 4, 'name' => 'fork of php-cs'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repositories')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldGetAllRepositoriesStartingIndex()
    {
        $expectedArray = [
            ['id' => 1, 'name' => 'dummy project'],
            ['id' => 2, 'name' => 'awesome another project'],
            ['id' => 3, 'name' => 'fork of php'],
            ['id' => 4, 'name' => 'fork of php-cs'],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repositories?since=2')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all(2));
    }

    /**
     * @test
     */
    public function shouldCreateRepositoryUsingNameOnly()
    {
        $expectedArray = ['id' => 1, 'name' => 'l3l0Repo'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/user/repos', [
                'name'          => 'l3l0Repo',
                'description'   => '',
                'homepage'      => '',
                'private'       => false,
                'has_issues'    => false,
                'has_wiki'      => false,
                'has_downloads' => false,
                'auto_init'     => false,
                'has_projects' => true,
            ])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create('l3l0Repo'));
    }

    /**
     * @test
     */
    public function shouldCreateRepositoryForOrganization()
    {
        $expectedArray = ['id' => 1, 'name' => 'KnpLabsRepo'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/orgs/KnpLabs/repos', [
                'name'          => 'KnpLabsRepo',
                'description'   => '',
                'homepage'      => '',
                'private'       => false,
                'has_issues'    => false,
                'has_wiki'      => false,
                'has_downloads' => false,
                'auto_init'     => false,
                'has_projects' => true,
            ])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create('KnpLabsRepo', '', '', true, 'KnpLabs'));
    }

    /**
     * @test
     */
    public function shouldGetRepositorySubscribers()
    {
        $expectedArray = [['id' => 1, 'username' => 'l3l0']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/subscribers', ['page' => 2])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->subscribers('KnpLabs', 'php-github-api', 2));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryTags()
    {
        $expectedArray = [['sha' => 1234]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/tags')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->tags('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryBranches()
    {
        $expectedArray = [['sha' => 1234, 'name' => 'master']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->branches('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryBranch()
    {
        $expectedArray = ['sha' => 1234, 'name' => 'master'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/branches/master')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->branches('KnpLabs', 'php-github-api', 'master'));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryLanguages()
    {
        $expectedArray = ['lang1', 'lang2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/languages')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->languages('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryMilestones()
    {
        $expectedArray = ['milestone1', 'milestone2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/milestones')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->milestones('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetContributorsExcludingAnonymousOnes()
    {
        $expectedArray = ['contrib1', 'contrib2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/contributors', ['anon' => null])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->contributors('KnpLabs', 'php-github-api', false));
    }

    /**
     * @test
     */
    public function shouldGetContributorsIncludingAnonymousOnes()
    {
        $expectedArray = ['contrib1', 'contrib2'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/contributors', ['anon' => true])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->contributors('KnpLabs', 'php-github-api', true));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryTeams()
    {
        $expectedArray = [['id' => 1234], ['id' => 2345]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/teams')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->teams('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldCreateUsingAllParams()
    {
        $expectedArray = ['id' => 1, 'name' => 'l3l0Repo'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/user/repos', [
                'name'          => 'l3l0Repo',
                'description'   => 'test',
                'homepage'      => 'http://l3l0.eu',
                'private'       => true,
                'has_issues'    => false,
                'has_wiki'      => false,
                'has_downloads' => false,
                'auto_init'     => false,
                'has_projects' => true,
            ])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->create('l3l0Repo', 'test', 'http://l3l0.eu', false));
    }

    /**
     * @test
     */
    public function shouldUpdate()
    {
        $expectedArray = ['id' => 1, 'name' => 'l3l0Repo'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('patch')
            ->with('/repos/l3l0Repo/test', ['description' => 'test', 'homepage' => 'http://l3l0.eu'])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('l3l0Repo', 'test', ['description' => 'test', 'homepage' => 'http://l3l0.eu']));
    }

    /**
     * @test
     */
    public function shouldDelete()
    {
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/l3l0Repo/test')
            ->will($this->returnValue(null));

        $this->assertNull($api->remove('l3l0Repo', 'test'));
    }

    /**
     * @test
     */
    public function shouldNotDelete()
    {
        $expectedArray = ['message' => 'Not Found'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('delete')
            ->with('/repos/l3l0Repo/uknown-repo')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->remove('l3l0Repo', 'uknown-repo'));
    }

    /**
     * @test
     */
    public function shouldGetCollaboratorsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\Collaborators::class, $api->collaborators());
    }

    /**
     * @test
     */
    public function shouldGetCommentsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\Comments::class, $api->comments());
    }

    /**
     * @test
     */
    public function shouldGetCommitsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\Commits::class, $api->commits());
    }

    /**
     * @test
     */
    public function shouldGetContentsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\Contents::class, $api->contents());
    }

    /**
     * @test
     */
    public function shouldGetDeployKeysApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\DeployKeys::class, $api->keys());
    }

    /**
     * @test
     */
    public function shouldGetDownloadsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\Downloads::class, $api->downloads());
    }

    /**
     * @test
     */
    public function shouldGetForksApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\Forks::class, $api->forks());
    }

    /**
     * @test
     */
    public function shouldGetHooksApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\Hooks::class, $api->hooks());
    }

    /**
     * @test
     */
    public function shouldGetLabelsApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\Labels::class, $api->labels());
    }

    /**
     * @test
     */
    public function shouldGetStatusesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\Statuses::class, $api->statuses());
    }

    /**
     * @test
     */
    public function shouldGetStargazersApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\Stargazers::class, $api->stargazers());
    }

    /**
     * @test
     */
    public function shouldGetReleasesApiObject()
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(\Github\Api\Repository\Releases::class, $api->releases());
    }

    /**
     * @test
     */
    public function shouldGetCommitActivity()
    {
        $expectedArray = [['days' => [0, 3, 26, 20, 39, 1, 0], 'total' => 89, 'week' => 1336280400]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/stats/commit_activity')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->activity('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryEvents()
    {
        $expectedArray = ['id' => 6122723754, 'type' => 'ForkEvent'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/events', [
                'page' => 3,
            ])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->events('KnpLabs', 'php-github-api', 3));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryCodeOfConduct()
    {
        $expectedArray = ['name' => 'Contributor Covenant', 'url' => 'http://...'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/community/code_of_conduct')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->codeOfConduct('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldGetRepositoryTopics()
    {
        $expectedArray = ['names' => ['octocat', 'atom', 'electron', 'API']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/repos/KnpLabs/php-github-api/topics')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->topics('KnpLabs', 'php-github-api'));
    }

    /**
     * @test
     */
    public function shouldReplaceRepositoryTopics()
    {
        $expectedArray = ['id' => 6122723754, 'type' => 'ForkEvent'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/repos/KnpLabs/php-github-api/topics', [
                'names' => ['octocat', 'atom', 'electron', 'API'],
            ])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->replaceTopics('KnpLabs', 'php-github-api', ['octocat', 'atom', 'electron', 'API']));
    }

    /**
     * @test
     */
    public function shouldTransferRepository()
    {
        $expectedArray = ['id' => 1, 'name' => 'php-github-api'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/repos/KnpLabs/php-github-api/transfer', [
                'new_owner' => 'github',
                'team_id' => [1234, 1235],
            ])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->transfer('KnpLabs', 'php-github-api', 'github', [1234, 1235]));
    }

    /**
     * @return string
     */
    protected function getApiClass()
    {
        return \Github\Api\Repo::class;
    }
}
