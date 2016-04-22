<?php

namespace Github\Api;

use Github\Api\Repository\Collaborators;
use Github\Api\Repository\Comments;
use Github\Api\Repository\Commits;
use Github\Api\Repository\Contents;
use Github\Api\Repository\DeployKeys;
use Github\Api\Repository\Downloads;
use Github\Api\Repository\Releases;
use Github\Api\Repository\Forks;
use Github\Api\Repository\Hooks;
use Github\Api\Repository\Labels;
use Github\Api\Repository\Stargazers;
use Github\Api\Repository\Statuses;

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
    /**
     * Search repositories by keyword.
     *
     * @link http://developer.github.com/v3/search/#search-repositories
     *
     * @param string $keyword the search query
     * @param array  $params
     *
     * @return array list of found repositories
     */
    public function find($keyword, array $params = array())
    {
        return $this->get('legacy/repos/search/'.rawurlencode($keyword), array_merge(array('start_page' => 1), $params));
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
    public function all($id = null)
    {
        if (!is_int($id)) {
            return $this->get('repositories');
        }

        return $this->get('repositories?since=' . rawurldecode($id));
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
    public function activity($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stats/commit_activity');
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
    public function statistics($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stats/contributors');
    }

    /**
     * List all repositories for an organization.
     *
     * @link http://developer.github.com/v3/repos/#list-organization-repositories
     *
     * @param string $organization the name of the organization
     * @param array  $params
     *
     * @return array list of organization repositories
     */
    public function org($organization, array $params = array())
    {
        return $this->get('orgs/'.$organization.'/repos', array_merge(array('start_page' => 1), $params));
    }

    /**
     * Get extended information about a repository by its username and repository name.
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array informations about the repository
     */
    public function show($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository));
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
        $name,
        $description = '',
        $homepage = '',
        $public = true,
        $organization = null,
        $hasIssues = false,
        $hasWiki = false,
        $hasDownloads = false,
        $teamId = null,
        $autoInit = false
    ) {
        $path = null !== $organization ? 'orgs/'.$organization.'/repos' : 'user/repos';

        $parameters = array(
            'name'          => $name,
            'description'   => $description,
            'homepage'      => $homepage,
            'private'       => !$public,
            'has_issues'    => $hasIssues,
            'has_wiki'      => $hasWiki,
            'has_downloads' => $hasDownloads,
            'auto_init'     => $autoInit
        );

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
     * @return array informations about the repository
     */
    public function update($username, $repository, array $values)
    {
        return $this->patch('repos/'.rawurlencode($username).'/'.rawurlencode($repository), $values);
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
    public function remove($username, $repository)
    {
        return $this->delete('repos/'.rawurlencode($username).'/'.rawurlencode($repository));
    }

    /**
     * Get the readme content for a repository by its username and repository name.
     *
     * @link http://developer.github.com/v3/repos/contents/#get-the-readme
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array the readme content
     */
    public function readme($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/readme');
    }

    /**
     * Manage the collaborators of a repository.
     *
     * @link http://developer.github.com/v3/repos/collaborators/
     *
     * @return Collaborators
     */
    public function collaborators()
    {
        return new Collaborators($this->client);
    }

    /**
     * Manage the comments of a repository.
     *
     * @link http://developer.github.com/v3/repos/comments/
     *
     * @return Comments
     */
    public function comments()
    {
        return new Comments($this->client);
    }

    /**
     * Manage the commits of a repository.
     *
     * @link http://developer.github.com/v3/repos/commits/
     *
     * @return Commits
     */
    public function commits()
    {
        return new Commits($this->client);
    }

    /**
     * Manage the content of a repository.
     *
     * @link http://developer.github.com/v3/repos/contents/
     *
     * @return Contents
     */
    public function contents()
    {
        return new Contents($this->client);
    }

    /**
     * Manage the content of a repository.
     *
     * @link http://developer.github.com/v3/repos/downloads/
     *
     * @return Downloads
     */
    public function downloads()
    {
        return new Downloads($this->client);
    }

    /**
     * Manage the releases of a repository (Currently Undocumented).
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @return Releases
     */
    public function releases()
    {
        return new Releases($this->client);
    }

    /**
     * Manage the deploy keys of a repository.
     *
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @return DeployKeys
     */
    public function keys()
    {
        return new DeployKeys($this->client);
    }

    /**
     * Manage the forks of a repository.
     *
     * @link http://developer.github.com/v3/repos/forks/
     *
     * @return Forks
     */
    public function forks()
    {
        return new Forks($this->client);
    }

    /**
     * Manage the stargazers of a repository.
     *
     * @link https://developer.github.com/v3/activity/starring/#list-stargazers
     *
     * @return Stargazers
     */
    public function stargazers()
    {
        return new Stargazers($this->client);
    }

    /**
     * Manage the hooks of a repository.
     *
     * @link http://developer.github.com/v3/issues/jooks/
     *
     * @return Hooks
     */
    public function hooks()
    {
        return new Hooks($this->client);
    }

    /**
     * Manage the labels of a repository.
     *
     * @link http://developer.github.com/v3/issues/labels/
     *
     * @return Labels
     */
    public function labels()
    {
        return new Labels($this->client);
    }

    /**
     * Manage the statuses of a repository.
     *
     * @link http://developer.github.com/v3/repos/statuses/
     *
     * @return Statuses
     */
    public function statuses()
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
    public function branches($username, $repository, $branch = null)
    {
        $url = 'repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/branches';
        if (null !== $branch) {
            $url .= '/'.rawurlencode($branch);
        }

        return $this->get($url);
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
    public function contributors($username, $repository, $includingAnonymous = false)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/contributors', array(
            'anon' => $includingAnonymous ?: null
        ));
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
    public function languages($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/languages');
    }

    /**
     * Get the tags of a repository.
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username   the user who owns the repository
     * @param string $repository the name of the repository
     *
     * @return array list of the repository tags
     */
    public function tags($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/tags');
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
    public function teams($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/teams');
    }

    /**
     * @deprecated see subscribers method
     *
     * @param string $username
     * @param string $repository
     * @param int    $page
     *
     * @return array
     */
    public function watchers($username, $repository, $page = 1)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/watchers', array(
            'page' => $page
        ));
    }

    /**
     * @param string $username
     * @param string $repository
     * @param int    $page
     *
     * @return array
     */
    public function subscribers($username, $repository, $page = 1)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/subscribers', array(
            'page' => $page
        ));
    }

    /**
     * Perform a merge.
     *
     * @link http://developer.github.com/v3/repos/merging/
     *
     * @param string $username
     * @param string $repository
     * @param string $base       The name of the base branch that the head will be merged into.
     * @param string $head       The head to merge. This can be a branch name or a commit SHA1.
     * @param string $message    Commit message to use for the merge commit. If omitted, a default message will be used.
     *
     * @return array|null
     */
    public function merge($username, $repository, $base, $head, $message = null)
    {
        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/merges', array(
            'base'           => $base,
            'head'           => $head,
            'commit_message' => $message
        ));
    }

    /**
     * @param string $username
     * @param string $repository
     * @return array
     */
    public function milestones($username, $repository)
    {
        return $this->get('repos/'.rawurldecode($username).'/'.rawurldecode($repository).'/milestones');
    }
}
