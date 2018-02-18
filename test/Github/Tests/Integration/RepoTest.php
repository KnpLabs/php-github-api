<?php

namespace Github\Tests\Integration;

/**
 * @group integration
 */
class RepoTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowPRDiffIfHeaderIsPresent()
    {
        $this->client->addHeaders(
            ['Accept' => sprintf(
                'application/vnd.github.%s.diff',
                $this->client->getApiVersion()
            )]
        );

        $diff = $this->client->api('pull_request')->show('KnpLabs', 'php-github-api', '92');

        $this->assertInternalType('string', $diff);
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
    public function shouldNotDecodeRawBlob()
    {
        $api = $this->client->api('git_data')->blobs();
        $api->configure('raw');

        $contents = $api->show(
            'KnpLabs',
            'php-github-api',
            'dc16d3e77fd4e40638cb722927ffe15fa85b1434'
        );

        $this->assertInternalType('string', $contents);
        $this->assertStringStartsWith('{', $contents);
    }

    /**
     * @test
     */
    public function shouldRetrieveContributorsList()
    {
        $username = 'KnpLabs';
        $repo = 'php-github-api';

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
        $repo = 'php-github-api';

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
