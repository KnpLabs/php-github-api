<?php

namespace Github\Api;

use Github\Api\Repository\Actions\Artifacts;
use Github\Api\Repository\Actions\Secrets;
use Github\Api\Repository\Actions\SelfHostedRunners;
use Github\Api\Repository\Actions\Variables;
use Github\Api\Repository\Actions\WorkflowJobs;
use Github\Api\Repository\Actions\WorkflowRuns;
use Github\Api\Repository\Actions\Workflows;
use Github\Api\Repository\Checks\CheckRuns;
use Github\Api\Repository\Checks\CheckSuites;
use Github\Api\Repository\Collaborators;
use Github\Api\Repository\Comments;
use Github\Api\Repository\Commits;
use Github\Api\Repository\Contents;
use Github\Api\Repository\DeployKeys;
use Github\Api\Repository\Downloads;
use Github\Api\Repository\Forks;
use Github\Api\Repository\Hooks;
use Github\Api\Repository\Labels;
use Github\Api\Repository\Pages;
use Github\Api\Repository\Projects;
use Github\Api\Repository\Protection;
use Github\Api\Repository\Releases;
use Github\Api\Repository\SecretScanning;
use Github\Api\Repository\Stargazers;
use Github\Api\Repository\Statuses;
use Github\Api\Repository\Traffic;

/**
 * Searching repositories, getting repository information
 * and managing repository information for authenticated users.
 *
 * @link   https://docs.github.com/rest/repos/repos
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis at gmail dot com>
 */
class Repo extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * List all public repositories.
     *
     * @link https://docs.github.com/rest/repos/repos#list-public-repositories
     *
     * @param int|null $id The integer ID of the last Repository that you’ve seen.
     *
     * @return array list of users found
     */
    public function all($id = null)
    {
        if (!is_int($id)) {
            return $this->get('/repositories');
        }

        return $this->get('/repositories', ['since' => $id]);
    }

    /**
     * Get the last year of commit activity for a repository grouped by week.
     *
     * @link https://docs.github.com/rest/metrics/statistics#get-the-last-year-of-commit-activity
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array commit activity grouped by week
     */
    public function activity($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stats/commit_activity');
    }

    /**
     * Get contributor commit statistics for a repository.
     *
     * @link https://docs.github.com/rest/metrics/statistics#get-all-contributor-commit-activity
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array list of contributors and their commit statistics
     */
    public function statistics($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stats/contributors');
    }

    /**
     * Get a weekly aggregate of the number of additions and deletions pushed to a repository.
     *
     * @link https://docs.github.com/rest/metrics/statistics#get-the-weekly-commit-activity
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array list of weeks and their commit statistics
     */
    public function frequency($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stats/code_frequency');
    }

    /**
     * Get the weekly commit count for the repository owner and everyone else.
     *
     * @link https://docs.github.com/rest/metrics/statistics#get-the-weekly-commit-count
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array list of weekly commit count grouped by 'all' and 'owner'
     */
    public function participation($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stats/participation');
    }

    /**
     * List all repositories for an organization.
     *
     * @link https://docs.github.com/rest/repos/repos#list-organization-repositories
     *
     * @param string $organization the name of the organization
     * @param array  $params
     *
     * @return array list of organization repositories
     */
    public function org($organization, array $params = [])
    {
        return $this->get('/orgs/'.$organization.'/repos', array_merge(['start_page' => 1], $params));
    }

    /**
     * Get extended information about a repository by its username and repository name.
     *
     * @link https://docs.github.com/rest/repos/repos#get-a-repository
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array information about the repository
     */
    public function show($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository));
    }

    /**
     * Get extended information about a repository by its id.
     * Note: at time of writing this is an undocumented feature but GitHub support have advised that it can be relied on.
     *
     * @link https://github.com/piotrmurach/github/issues/283
     * @link https://github.com/piotrmurach/github/issues/282
     *
     * @param int $id the id of the repository
     *
     * @return array information about the repository
     */
    public function showById($id)
    {
        return $this->get('/repositories/'.$id);
    }

    /**
     * Create repository.
     *
     * @link https://docs.github.com/rest/repos/repos#create-a-repository-for-the-authenticated-user
     * @link https://docs.github.com/rest/repos/repos#create-an-organization-repository
     *
     * @param string      $name         name of the repository
     * @param string      $description  repository description
     * @param string      $homepage     homepage url
     * @param bool        $public       `true` for public, `false` for private
     * @param string|null $organization username of organization if applicable
     * @param bool        $hasIssues    `true` to enable issues for this repository, `false` to disable them
     * @param bool        $hasWiki      `true` to enable the wiki for this repository, `false` to disable it
     * @param bool        $hasDownloads `true` to enable downloads for this repository, `false` to disable them
     * @param int         $teamId       The id of the team that will be granted access to this repository. This is only valid when creating a repo in an organization.
     * @param bool        $autoInit     `true` to create an initial commit with empty README, `false` for no initial commit
     * @param bool        $hasProjects  `true` to enable projects for this repository or false to disable them.
     * @param string|null $visibility
     *
     * @return array returns repository data
     */
    public function create(
        $name,
        $description = '',
        $homepage = '',
        $public = true,
        $organization = null,
        $hasIssues = false,
        $hasWiki = false,
        $hasDownloads = false,
        $teamId = null,
        $autoInit = false,
        $hasProjects = true,
        $visibility = null
    ) {
        $path = null !== $organization ? '/orgs/'.$organization.'/repos' : '/user/repos';

        $parameters = [
            'name' => $name,
            'description' => $description,
            'homepage' => $homepage,
            'private' => ($visibility ?? ($public ? 'public' : 'private')) === 'private',
            'has_issues' => $hasIssues,
            'has_wiki' => $hasWiki,
            'has_downloads' => $hasDownloads,
            'auto_init' => $autoInit,
            'has_projects' => $hasProjects,
        ];

        if ($visibility) {
            $parameters['visibility'] = $visibility;
        }

        if ($organization && $teamId) {
            $parameters['team_id'] = $teamId;
        }

        return $this->post($path, $parameters);
    }

    /**
     * Set information of a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#update-a-repository
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     * @param array  $values     the key => value pairs to post
     *
     * @return array information about the repository
     */
    public function update($username, $repository, array $values)
    {
        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository), $values);
    }

    /**
     * Delete a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#delete-a-repository
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return mixed null on success, array on error with 'message'
     */
    public function remove($username, $repository)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository));
    }

    /**
     * Get the readme content for a repository by its username and repository name.
     *
     * @link https://docs.github.com/rest/repos/contents#get-a-repository-readme
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     * @param string $format     one of formats: "raw", "html", or "v3+json"
     * @param string $dir        The alternate path to look for a README file
     * @param array  $params     additional query params like "ref" to fetch readme for branch/tag
     *
     * @return string|array the readme content
     */
    public function readme($username, $repository, $format = 'raw', $dir = null, $params = [])
    {
        $path = '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/readme';

        if (null !== $dir) {
            $path .= '/'.rawurlencode($dir);
        }

        return $this->get($path, $params, [
            'Accept' => "application/vnd.github.$format",
        ]);
    }

    /**
     * Create a repository dispatch event.
     *
     * @link https://docs.github.com/rest/repos/repos#create-a-repository-dispatch-event
     *
     * @param string       $username      the user who owns the repository
     * @param string       $repository    the name of the repository
     * @param string       $eventType     A custom webhook event name
     * @param array|object $clientPayload The payload to pass to Github.
     *
     * @return mixed null on success, array on error with 'message'
     */
    public function dispatch($username, $repository, $eventType, $clientPayload)
    {
        if (is_array($clientPayload)) {
            $clientPayload = (object) $clientPayload;
        }

        return $this->post(\sprintf('/repos/%s/%s/dispatches', rawurlencode($username), rawurlencode($repository)), [
            'event_type' => $eventType,
            'client_payload' => $clientPayload,
        ]);
    }

    /**
     * Manage the collaborators of a repository.
     *
     * @link https://docs.github.com/rest/collaborators/collaborators
     *
     * @return Collaborators
     */
    public function collaborators()
    {
        return new Collaborators($this->getClient());
    }

    /**
     * Manage the comments of a repository.
     *
     * @link https://docs.github.com/rest/commits/comments
     *
     * @return Comments
     */
    public function comments()
    {
        return new Comments($this->getClient());
    }

    /**
     * Manage the commits of a repository.
     *
     * @link https://docs.github.com/rest/commits/commits
     *
     * @return Commits
     */
    public function commits()
    {
        return new Commits($this->getClient());
    }

    /**
     * @link https://docs.github.com/rest/checks/runs
     */
    public function checkRuns(): CheckRuns
    {
        return new CheckRuns($this->getClient());
    }

    /**
     * @link https://docs.github.com/rest/checks/suites
     */
    public function checkSuites(): CheckSuites
    {
        return new CheckSuites($this->getClient());
    }

    /**
     * @link https://docs.github.com/rest/actions/artifacts
     */
    public function artifacts(): Artifacts
    {
        return new Artifacts($this->getClient());
    }

    /**
     * @link https://docs.github.com/rest/actions/workflows
     */
    public function workflows(): Workflows
    {
        return new Workflows($this->getClient());
    }

    /**
     * @link https://docs.github.com/rest/actions/workflow-runs
     */
    public function workflowRuns(): WorkflowRuns
    {
        return new WorkflowRuns($this->getClient());
    }

    /**
     * @link https://docs.github.com/rest/actions/workflow-jobs
     */
    public function workflowJobs(): WorkflowJobs
    {
        return new WorkflowJobs($this->getClient());
    }

    /**
     * @link https://docs.github.com/rest/actions/self-hosted-runners
     */
    public function selfHostedRunners(): SelfHostedRunners
    {
        return new SelfHostedRunners($this->getClient());
    }

    /**
     * @link https://docs.github.com/rest/actions/secrets
     */
    public function secrets(): Secrets
    {
        return new Secrets($this->getClient());
    }

    /**
     * @link https://docs.github.com/rest/actions/variables
     */
    public function variables(): Variables
    {
        return new Variables($this->getClient());
    }

    /**
     * Manage the content of a repository.
     *
     * @link https://docs.github.com/rest/repos/contents
     *
     * @return Contents
     */
    public function contents()
    {
        return new Contents($this->getClient());
    }

    /**
     * Manage the content of a repository.
     *
     * Note: the Downloads API has been removed by GitHub; there is no current
     * docs.github.com endpoint backing this sub-API.
     *
     * @return Downloads
     */
    public function downloads()
    {
        return new Downloads($this->getClient());
    }

    /**
     * Manage the releases of a repository.
     *
     * @link https://docs.github.com/rest/releases/releases
     *
     * @return Releases
     */
    public function releases()
    {
        return new Releases($this->getClient());
    }

    /**
     * Manage the deploy keys of a repository.
     *
     * @link https://docs.github.com/rest/deploy-keys/deploy-keys
     *
     * @return DeployKeys
     */
    public function keys()
    {
        return new DeployKeys($this->getClient());
    }

    /**
     * Manage the forks of a repository.
     *
     * @link https://docs.github.com/rest/repos/forks
     *
     * @return Forks
     */
    public function forks()
    {
        return new Forks($this->getClient());
    }

    /**
     * Manage the stargazers of a repository.
     *
     * @link https://docs.github.com/rest/activity/starring#list-stargazers
     *
     * @return Stargazers
     */
    public function stargazers()
    {
        return new Stargazers($this->getClient());
    }

    /**
     * Manage the hooks of a repository.
     *
     * @link https://docs.github.com/rest/webhooks/repos
     *
     * @return Hooks
     */
    public function hooks()
    {
        return new Hooks($this->getClient());
    }

    /**
     * Manage the labels of a repository.
     *
     * @link https://docs.github.com/rest/issues/labels
     *
     * @return Labels
     */
    public function labels()
    {
        return new Labels($this->getClient());
    }

    /**
     * Manage the statuses of a repository.
     *
     * @return Statuses
     */
    public function statuses()
    {
        return new Statuses($this->getClient());
    }

    /**
     * Get the branch(es) of a repository.
     *
     * @link https://docs.github.com/rest/branches/branches
     *
     * @param string $username   the username
     * @param string $repository the name of the repository
     * @param string $branch     the name of the branch
     * @param array  $parameters parameters for the query string
     *
     * @return array list of the repository branches
     */
    public function branches($username, $repository, $branch = null, array $parameters = [])
    {
        $url = '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/branches';
        if (null !== $branch) {
            $url .= '/'.rawurlencode($branch);
        }

        return $this->get($url, $parameters);
    }

    /**
     * Sync a fork branch with the upstream repository.
     *
     * @link https://docs.github.com/rest/branches/branches#sync-a-fork-branch-with-the-upstream-repository
     *
     * @return array|string
     */
    public function mergeUpstream(string $username, string $repository, string $branchName)
    {
        return $this->post(
            '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/merge-upstream',
            ['branch' => $branchName]
        );
    }

    /**
     * Manage the protection of a repository branch.
     *
     * @return Protection
     */
    public function protection()
    {
        return new Protection($this->getClient());
    }

    /**
     * Get the contributors of a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#list-repository-contributors
     *
     * @param string $username           the user who owns the repository
     * @param string $repository         the name of the repository
     * @param bool   $includingAnonymous by default, the list only shows GitHub users.
     *                                   You can include non-users too by setting this to true
     *
     * @return array list of the repo contributors
     */
    public function contributors($username, $repository, $includingAnonymous = false)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/contributors', [
            'anon' => $includingAnonymous ?: null,
        ]);
    }

    /**
     * Get the language breakdown of a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#list-repository-languages
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array list of the languages
     */
    public function languages($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/languages');
    }

    /**
     * Get the tags of a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#list-repository-tags
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     * @param array  $params     the additional parameters like milestone, assignees, labels, sort, direction
     *
     * @return array list of the repository tags
     */
    public function tags($username, $repository, array $params = [])
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/tags', $params);
    }

    /**
     * Get the teams of a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#list-repository-teams
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     *
     * @return array list of the languages
     */
    public function teams($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/teams');
    }

    /**
     * List the watchers of a repository.
     *
     * @link https://docs.github.com/rest/activity/watching#list-watchers
     *
     * @param string $username
     * @param string $repository
     * @param int    $page
     *
     * @return array
     */
    public function subscribers($username, $repository, $page = 1)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/subscribers', [
            'page' => $page,
        ]);
    }

    /**
     * Perform a merge.
     *
     * @link https://docs.github.com/rest/branches/branches#merge-a-branch
     *
     * @param string $username
     * @param string $repository
     * @param string $base       The name of the base branch that the head will be merged into.
     * @param string $head       The head to merge. This can be a branch name or a commit SHA1.
     * @param string $message    Commit message to use for the merge commit. If omitted, a default message will be used.
     *
     * @return array|string
     */
    public function merge($username, $repository, $base, $head, $message = null)
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

    /**
     * List milestones for a repository.
     *
     * @link https://docs.github.com/rest/issues/milestones#list-milestones
     *
     * @param string $username
     * @param string $repository
     * @param array  $parameters
     *
     * @return array
     */
    public function milestones($username, $repository, array $parameters = [])
    {
        return $this->get('/repos/'.rawurldecode($username).'/'.rawurldecode($repository).'/milestones', $parameters);
    }

    /**
     * @link https://docs.github.com/rest/repos/repos#enable-dependabot-security-updates
     *
     * @param string $username
     * @param string $repository
     *
     * @return array|string
     */
    public function enableAutomatedSecurityFixes(string $username, string $repository)
    {
        $this->acceptHeaderValue = 'application/vnd.github.london-preview+json';

        return $this->put('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/automated-security-fixes');
    }

    /**
     * @link https://docs.github.com/rest/repos/repos#disable-dependabot-security-updates
     *
     * @param string $username
     * @param string $repository
     *
     * @return array|string
     */
    public function disableAutomatedSecurityFixes(string $username, string $repository)
    {
        $this->acceptHeaderValue = 'application/vnd.github.london-preview+json';

        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/automated-security-fixes');
    }

    /**
     * Manage the (classic) projects of a repository.
     *
     * @link https://docs.github.com/rest/projects/projects
     *
     * @return Projects
     */
    public function projects()
    {
        return new Projects($this->getClient());
    }

    /**
     * Get the traffic metrics of a repository.
     *
     * @link https://docs.github.com/rest/metrics/traffic
     *
     * @return Traffic
     */
    public function traffic()
    {
        return new Traffic($this->getClient());
    }

    /**
     * Manage GitHub Pages for a repository.
     *
     * @link https://docs.github.com/rest/pages/pages
     *
     * @return Pages
     */
    public function pages()
    {
        return new Pages($this->getClient());
    }

    /**
     * @param string $username
     * @param string $repository
     * @param int    $page
     *
     * @return array|string
     *
     * @see https://docs.github.com/rest/activity/events#list-repository-events
     */
    public function events($username, $repository, $page = 1)
    {
        return $this->get('/repos/'.rawurldecode($username).'/'.rawurldecode($repository).'/events', ['page' => $page]);
    }

    /**
     * Get the community profile metrics for a repository.
     *
     * @link https://docs.github.com/rest/metrics/community#get-community-profile-metrics
     *
     * @param string $username
     * @param string $repository
     *
     * @return array
     */
    public function communityProfile($username, $repository)
    {
        //This api is in preview mode, so set the correct accept-header
        $this->acceptHeaderValue = 'application/vnd.github.black-panther-preview+json';

        return $this->get('/repos/'.rawurldecode($username).'/'.rawurldecode($repository).'/community/profile');
    }

    /**
     * Get the contents of a repository's code of conduct.
     *
     * @link https://docs.github.com/rest/codes-of-conduct/codes-of-conduct
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
     * List all topics for a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#get-all-repository-topics
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
     * Replace all topics for a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#replace-all-repository-topics
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

    /**
     * Transfer a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#transfer-a-repository
     *
     * @param string $username
     * @param string $repository
     * @param string $newOwner
     * @param array  $teamId
     *
     * @return array
     */
    public function transfer($username, $repository, $newOwner, $teamId = [])
    {
        return $this->post('/repos/'.rawurldecode($username).'/'.rawurldecode($repository).'/transfer', ['new_owner' => $newOwner, 'team_id' => $teamId]);
    }

    /**
     * Create a repository using a template.
     *
     * @link https://docs.github.com/rest/repos/repos#create-a-repository-using-a-template
     *
     * @return array
     */
    public function createFromTemplate(string $templateOwner, string $templateRepo, array $parameters = [])
    {
        //This api is in preview mode, so set the correct accept-header
        $this->acceptHeaderValue = 'application/vnd.github.baptiste-preview+json';

        return $this->post('/repos/'.rawurldecode($templateOwner).'/'.rawurldecode($templateRepo).'/generate', $parameters);
    }

    /**
     * Check if vulnerability alerts are enabled for a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#check-if-vulnerability-alerts-are-enabled-for-a-repository
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array|string
     */
    public function isVulnerabilityAlertsEnabled(string $username, string $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/vulnerability-alerts');
    }

    /**
     * Enable vulnerability alerts for a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#enable-vulnerability-alerts
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array|string
     */
    public function enableVulnerabilityAlerts(string $username, string $repository)
    {
        return $this->put('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/vulnerability-alerts');
    }

    /**
     * Disable vulnerability alerts for a repository.
     *
     * @link https://docs.github.com/rest/repos/repos#disable-vulnerability-alerts
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array|string
     */
    public function disableVulnerabilityAlerts(string $username, string $repository)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/vulnerability-alerts');
    }

    /**
     * Manage secret scanning alerts for a repository.
     *
     * @link https://docs.github.com/rest/secret-scanning/secret-scanning
     *
     * @return SecretScanning
     */
    public function secretScanning(): SecretScanning
    {
        return new SecretScanning($this->getClient());
    }
}
