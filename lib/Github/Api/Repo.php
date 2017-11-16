<?php declare(strict_types=1);

namespace Github\Api;

use Github\Api\Repository\Collaborators;
use Github\Api\Repository\Comments;
use Github\Api\Repository\Commits;
use Github\Api\Repository\Contents;
use Github\Api\Repository\DeployKeys;
use Github\Api\Repository\Downloads;
use Github\Api\Repository\Forks;
use Github\Api\Repository\Hooks;
use Github\Api\Repository\Labels;
use Github\Api\Repository\Projects;
use Github\Api\Repository\Protection;
use Github\Api\Repository\Releases;
use Github\Api\Repository\Stargazers;
use Github\Api\Repository\Statuses;
use Github\Api\Repository\Traffic;

/**
 * Searching repositories, getting repository information
 * and managing repository information for authenticated users.
 *
 * @link   http://developer.github.com/v3/repos/
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis at gmail dot com>
 */
class Repo extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Search repositories by keyword.
     *
     * @deprecated This method is deprecated use the Search api instead. See https://developer.github.com/v3/search/legacy/#legacy-search-api-is-deprecated
     *
     * @link http://developer.github.com/v3/search/#search-repositories
     *
     * @param string $keyword the search query
     *
     * @return array list of found repositories
     */
    public function find(string $keyword, array $params = []): array
    {
        return $this->get('/legacy/repos/search/'.rawurlencode($keyword), array_merge(['start_page' => 1], $params));
    }

    /**
     * List all public repositories.
     *
     * @link https://developer.github.com/v3/repos/#list-all-public-repositories
     *
     * @param int|null $id The integer ID of the last Repository that you’ve seen.
     *
     * @return array list of users found
     */
    public function all(int $id = null): array
    {
        if (!is_int($id)) {
            return $this->get('/repositories');
        }

        return $this->get('/repositories?since=' . rawurldecode($id));
    }

    /**
     * Get the last year of commit activity for a repository grouped by week.
     *
     * @link http://developer.github.com/v3/repos/statistics/#commit-activity
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array commit activity grouped by week
     */
    public function activity(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stats/commit_activity');
    }

    /**
     * Get contributor commit statistics for a repository.
     *
     * @link http://developer.github.com/v3/repos/statistics/#contributors
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array list of contributors and their commit statistics
     */
    public function statistics(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stats/contributors');
    }

    /**
     * Get a weekly aggregate of the number of additions and deletions pushed to a repository.
     *
     * @link http://developer.github.com/v3/repos/statistics/#code-frequency
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array list of weeks and their commit statistics
     */
    public function frequency(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stats/code_frequency');
    }

    /**
     * Get the weekly commit count for the repository owner and everyone else.
     *
     * @link http://developer.github.com/v3/repos/statistics/#participation
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array list of weekly commit count grouped by 'all' and 'owner'
     */
    public function participation(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stats/participation');
    }

    /**
     * List all repositories for an organization.
     *
     * @link http://developer.github.com/v3/repos/#list-organization-repositories
     *
     * @param string $organization the name of the organization
     *
     * @return array list of organization repositories
     */
    public function org(string $organization, array $params = []): array
    {
        return $this->get('/orgs/'.$organization.'/repos', array_merge(['start_page' => 1], $params));
    }

    /**
     * Get extended information about a repository by its username and repository name.
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array information about the repository
     */
    public function show(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository));
    }

    /**
     * Get extended information about a repository by its id.
     * Note: at time of writing this is an undocumented feature but GitHub support have advised that it can be relied on.
     *
     * @link http://developer.github.com/v3/repos/
     * @link https://github.com/piotrmurach/github/issues/283
     * @link https://github.com/piotrmurach/github/issues/282
     *
     * @param int $id   the id of the repository
     *
     * @return array information about the repository
     */
    public function showById(int $id): array
    {
        return $this->get('/repositories/'.rawurlencode((string) $id));
    }

    /**
     * Create repository.
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string      $name         name of the repository
     * @param string      $description  repository description
     * @param string      $homepage     homepage url
     * @param bool        $public       `true` for public, `false` for private
     * @param null|string $organization username of organization if applicable
     * @param bool        $hasIssues    `true` to enable issues for this repository, `false` to disable them
     * @param bool        $hasWiki      `true` to enable the wiki for this repository, `false` to disable it
     * @param bool        $hasDownloads `true` to enable downloads for this repository, `false` to disable them
     * @param int         $teamId       The id of the team that will be granted access to this repository. This is only valid when creating a repo in an organization.
     * @param bool        $autoInit     `true` to create an initial commit with empty README, `false` for no initial commit
     *
     * @return array returns repository data
     */
    public function create(
        string $name,
        string $description = '',
        string $homepage = '',
        bool $public = true,
        string $organization = null,
        bool $hasIssues = false,
        bool $hasWiki = false,
        bool $hasDownloads = false,
        int $teamId = null,
        bool $autoInit = false
    ): array {
        $path = null !== $organization ? '/orgs/'.$organization.'/repos' : '/user/repos';

        $parameters = [
            'name'          => $name,
            'description'   => $description,
            'homepage'      => $homepage,
            'private'       => !$public,
            'has_issues'    => $hasIssues,
            'has_wiki'      => $hasWiki,
            'has_downloads' => $hasDownloads,
            'auto_init'     => $autoInit
        ];

        if ($organization && $teamId) {
            $parameters['team_id'] = $teamId;
        }

        return $this->post($path, $parameters);
    }

    /**
     * Set information of a repository.
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     * @param array  $values     the key => value pairs to post
     *
     * @return array information about the repository
     */
    public function update(string $username, string $repository, array $values): array
    {
        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository), $values);
    }

    /**
     * Delete a repository.
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return mixed null on success, array on error with 'message'
     */
    public function remove(string $username, string $repository)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository));
    }

    /**
     * Get the readme content for a repository by its username and repository name.
     *
     * @link http://developer.github.com/v3/repos/contents/#get-the-readme
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     * @param string $format     one of formats: "raw", "html", or "v3+json"
     *
     * @return string|array the readme content
     */
    public function readme(string $username, string $repository, string $format = 'raw')
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/readme', [], [
            'Accept' => "application/vnd.github.$format",
        ]);
    }

    /**
     * Manage the collaborators of a repository.
     *
     * @link http://developer.github.com/v3/repos/collaborators/
     */
    public function collaborators(): Collaborators
    {
        return new Collaborators($this->client);
    }

    /**
     * Manage the comments of a repository.
     *
     * @link http://developer.github.com/v3/repos/comments/
     */
    public function comments(): Comments
    {
        return new Comments($this->client);
    }

    /**
     * Manage the commits of a repository.
     *
     * @link http://developer.github.com/v3/repos/commits/
     */
    public function commits(): Commits
    {
        return new Commits($this->client);
    }

    /**
     * Manage the content of a repository.
     *
     * @link http://developer.github.com/v3/repos/contents/
     */
    public function contents(): Contents
    {
        return new Contents($this->client);
    }

    /**
     * Manage the content of a repository.
     *
     * @link http://developer.github.com/v3/repos/downloads/
     */
    public function downloads(): Downloads
    {
        return new Downloads($this->client);
    }

    /**
     * Manage the releases of a repository (Currently Undocumented).
     *
     * @link http://developer.github.com/v3/repos/
     */
    public function releases(): Releases
    {
        return new Releases($this->client);
    }

    /**
     * Manage the deploy keys of a repository.
     *
     * @link http://developer.github.com/v3/repos/keys/
     */
    public function keys(): DeployKeys
    {
        return new DeployKeys($this->client);
    }

    /**
     * Manage the forks of a repository.
     *
     * @link http://developer.github.com/v3/repos/forks/
     */
    public function forks(): Forks
    {
        return new Forks($this->client);
    }

    /**
     * Manage the stargazers of a repository.
     *
     * @link https://developer.github.com/v3/activity/starring/#list-stargazers
     */
    public function stargazers(): Stargazers
    {
        return new Stargazers($this->client);
    }

    /**
     * Manage the hooks of a repository.
     *
     * @link http://developer.github.com/v3/issues/jooks/
     */
    public function hooks(): Hooks
    {
        return new Hooks($this->client);
    }

    /**
     * Manage the labels of a repository.
     *
     * @link http://developer.github.com/v3/issues/labels/
     */
    public function labels(): Labels
    {
        return new Labels($this->client);
    }

    /**
     * Manage the statuses of a repository.
     *
     * @link http://developer.github.com/v3/repos/statuses/
     */
    public function statuses(): Statuses
    {
        return new Statuses($this->client);
    }

    /**
     * Get the branch(es) of a repository.
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username   the username
     * @param string $repository the name of the repository
     * @param string $branch     the name of the branch
     *
     * @return array list of the repository branches
     */
    public function branches(string $username, string $repository, string $branch = null): array
    {
        $url = '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/branches';
        if (null !== $branch) {
            $url .= '/'.rawurlencode($branch);
        }

        return $this->get($url);
    }

    /**
     * Manage the protection of a repository branch.
     *
     * @link https://developer.github.com/v3/repos/branches/#get-branch-protection
     */
    public function protection(): Protection
    {
        return new Protection($this->client);
    }

    /**
     * Get the contributors of a repository.
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username           the user who owns the repository
     * @param string $repository         the name of the repository
     * @param bool   $includingAnonymous by default, the list only shows GitHub users.
     *                                   You can include non-users too by setting this to true
     *
     * @return array list of the repo contributors
     */
    public function contributors(string $username, string $repository, bool $includingAnonymous = false): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/contributors', [
            'anon' => $includingAnonymous ?: null
        ]);
    }

    /**
     * Get the language breakdown of a repository.
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array list of the languages
     */
    public function languages(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/languages');
    }

    /**
     * Get the tags of a repository.
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     * @param array  $params     the additional parameters like milestone, assignees, labels, sort, direction
     *
     * @return array list of the repository tags
     */
    public function tags(string $username, string $repository, array $params = []): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/tags', $params);
    }

    /**
     * Get the teams of a repository.
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     *
     * @return array list of the languages
     */
    public function teams(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/teams');
    }

    /**
     * @deprecated see subscribers method
     */
    public function watchers(string $username, string $repository, int $page = 1): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/watchers', [
            'page' => $page
        ]);
    }

    public function subscribers(string $username, string $repository, int $page = 1): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/subscribers', [
            'page' => $page
        ]);
    }

    /**
     * Perform a merge.
     *
     * @link http://developer.github.com/v3/repos/merging/
     *
     * @param string $base       The name of the base branch that the head will be merged into.
     * @param string $head       The head to merge. This can be a branch name or a commit SHA1.
     * @param string $message    Commit message to use for the merge commit. If omitted, a default message will be used.
     *
     * @return array|null
     */
    public function merge(string $username, string $repository, string $base, string $head, string $message = null)
    {
        $parameters = [
            'base' => $base,
            'head' => $head,
        ];

        if (is_string($message)) {
            $parameters['commit_message'] = $message;
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/merges', $parameters);
    }

    public function milestones(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurldecode($username).'/'.rawurldecode($repository).'/milestones');
    }

    public function projects()
    {
        return new Projects($this->client);
    }

    public function traffic()
    {
        return new Traffic($this->client);
    }

    /**
     * @return array|string
     *
     * @see https://developer.github.com/v3/activity/events/#list-repository-events
     */
    public function events(string $username, string $repository, int $page = 1)
    {
        return $this->get('/repos/'.rawurldecode($username).'/'.rawurldecode($repository).'/events', ['page' => $page]);
    }

    /**
     * Get the contents of a repository's code of conduct
     *
     * @link https://developer.github.com/v3/codes_of_conduct/#get-the-contents-of-a-repositorys-code-of-conduct
     *
     * @param string $username
     * @param string $repository
     *
     * @return array
     */
    public function codeOfConduct($username, $repository)
    {
        //This api is in preview mode, so set the correct accept-header
        $this->acceptHeaderValue = 'application/vnd.github.scarlet-witch-preview+json';

        return $this->get('/repos/'.rawurldecode($username).'/'.rawurldecode($repository).'/community/code_of_conduct');
    }

    /**
     * List all topics for a repository
     *
     * @link https://developer.github.com/v3/repos/#list-all-topics-for-a-repository
     *
     * @param string $username
     * @param string $repository
     *
     * @return array
     */
    public function topics($username, $repository)
    {
        //This api is in preview mode, so set the correct accept-header
        $this->acceptHeaderValue = 'application/vnd.github.mercy-preview+json';

        return $this->get('/repos/'.rawurldecode($username).'/'.rawurldecode($repository).'/topics');
    }

    /**
     * Replace all topics for a repository
     *
     * @link https://developer.github.com/v3/repos/#replace-all-topics-for-a-repository
     *
     * @param string $username
     * @param string $repository
     * @param array  $topics
     *
     * @return array
     */
    public function replaceTopics($username, $repository, array $topics)
    {
        //This api is in preview mode, so set the correct accept-header
        $this->acceptHeaderValue = 'application/vnd.github.mercy-preview+json';

        return $this->put('/repos/'.rawurldecode($username).'/'.rawurldecode($repository).'/topics', ['names' => $topics]);
    }
}
