<?php

namespace Github\Tests\Functional;

/**
 * @group functional
 */
class RepoTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowPRDiffIfHeaderIsPresent()
    {
        $this->client->setHeaders(
            array('Accept' => sprintf(
                'application/vnd.github.%s.diff',
                $this->client->getOption('api_version')
            ))
        );

        $diff = $this->client->api('pull_request')->show('KnpLabs', 'php-github-api', '92');

        $this->assertTrue('string' === gettype($diff));
    }

    /**
     * @test
     */
    public function shouldRetrieveRawBlob()
    {
        $api = $this->client->api('git_data')->blobs();
        $api->configure('raw');

        $contents = $api->show(
            'KnpLabs',
            'php-github-api',
            'e50d5e946385cff052636e2f09f36b03d1c368f4'
        );

        $this->assertInternalType('string', $contents);
        $this->assertStringStartsWith('<?php', $contents);
    }

    /**
     * @test
     */
    public function shouldRetrieveContributorsList()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';

        $contributors = $this->client->api('repo')->contributors($username, $repo);
        $contributor = array_pop($contributors);

        $this->assertArrayHasKey('url', $contributor);
        $this->assertArrayHasKey('gravatar_id', $contributor);
        $this->assertArrayHasKey('contributions', $contributor);
        $this->assertArrayHasKey('avatar_url', $contributor);
        $this->assertArrayHasKey('login', $contributor);
        $this->assertArrayHasKey('id', $contributor);
    }

    /**
     * @test
     */
    public function shouldShowRepo()
    {
        $username = 'KnpLabs';
        $repo     = 'php-github-api';

        $repo = $this->client->api('repo')->show($username, $repo);

        $this->assertArrayHasKey('id', $repo);
        $this->assertArrayHasKey('name', $repo);
        $this->assertArrayHasKey('description', $repo);
        $this->assertArrayHasKey('url', $repo);
        $this->assertArrayHasKey('has_wiki', $repo);
        $this->assertArrayHasKey('has_issues', $repo);
        $this->assertArrayHasKey('forks', $repo);
        $this->assertArrayHasKey('updated_at', $repo);
        $this->assertArrayHasKey('created_at', $repo);
        $this->assertArrayHasKey('pushed_at', $repo);
        $this->assertArrayHasKey('open_issues', $repo);
        $this->assertArrayHasKey('ssh_url', $repo);
        $this->assertArrayHasKey('git_url', $repo);
        $this->assertArrayHasKey('svn_url', $repo);
    }
}
