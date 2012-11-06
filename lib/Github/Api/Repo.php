<?php

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
     * Search repositories by keyword:
     * @link http://developer.github.com/v3/search/#search-repositories
     *
     * @param  string $keyword          the search query
     * @param  array  $params
     *
     * @return array                    list of founded repositories
     */
    public function find($keyword, array $params)
    {
        return $this->get('legacy/repos/search/'.urlencode($keyword), array_merge(array('start_page' => 1), $params));
    }

    /**
     * Get extended information about a repository by its username and repository name
     * @link http://developer.github.com/v3/repos/
     *
     * @param  string  $username         the user who owns the repository
     * @param  string  $repository       the name of the repository
     *
     * @return array                     informations about the repository
     */
    public function show($username, $repository)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository));
    }

    /**
     * Create repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param  string  $name             name of the repository
     * @param  string  $description      repository description
     * @param  string  $homepage         homepage url
     * @param  boolean $public           `true` for public, `false` for private
     * @param  null|string $organization username of organization if applicable
     *
     * @return array                     returns repository data
     */
    public function create($name, $description = '', $homepage = '', $public = true, $organization = null)
    {
        $path = null !== $organization ? 'orgs/'.$organization.'/repos' : 'user/repos';

        return $this->post($path, array(
            'name'        => $name,
            'description' => $description,
            'homepage'    => $homepage,
            'private'     => !$public
        ));
    }

    /**
     * Set information of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param  string  $username         the user who owns the repository
     * @param  string  $repository       the name of the repository
     * @param  array   $values           the key => value pairs to post
     *
     * @return array                     informations about the repository
     */
    public function update($username, $repository, array $values)
    {
        return $this->patch('repos/'.urlencode($username).'/'.urlencode($repository), $values);
    }

    /**
     * Delete a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username          the user who owns the repository
     * @param string $repository        the name of the repository
     *
     * @return mixed                    null on success, array on error with 'message'
     */
    public function remove($username, $repository)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repository));
    }

    /**
     * Manage the collaborators of a repository
     * @link http://developer.github.com/v3/repos/collaborators/
     *
     * @return Collaborators
     */
    public function collaborators()
    {
        return new Collaborators($this->client);
    }

    /**
     * Manage the comments of a repository
     * @link http://developer.github.com/v3/repos/comments/
     *
     * @return Comments
     */
    public function comments()
    {
        return new Comments($this->client);
    }

    /**
     * Manage the commits of a repository
     * @link http://developer.github.com/v3/repos/commits/
     *
     * @return Commits
     */
    public function commits()
    {
        return new Commits($this->client);
    }

    /**
     * Manage the content of a repository
     * @link http://developer.github.com/v3/repos/contents/
     *
     * @return Contents
     */
    public function contents()
    {
        return new Contents($this->client);
    }

    /**
     * Manage the content of a repository
     * @link http://developer.github.com/v3/repos/downloads/
     *
     * @return Downloads
     */
    public function downloads()
    {
        return new Downloads($this->client);
    }

    /**
     * Manage the deploy keys of a repository
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @return DeployKeys
     */
    public function keys()
    {
        return new DeployKeys($this->client);
    }

    /**
     * Manage the forks of a repository
     * @link http://developer.github.com/v3/repos/forks/
     *
     * @return Forks
     */
    public function forks()
    {
        return new Forks($this->client);
    }

    /**
     * Manage the hooks of a repository
     * @link http://developer.github.com/v3/issues/jooks/
     *
     * @return Hooks
     */
    public function hooks()
    {
        return new Hooks($this->client);
    }

    /**
     * Manage the labels of a repository
     * @link http://developer.github.com/v3/issues/labels/
     *
     * @return Labels
     */
    public function labels()
    {
        return new Labels($this->client);
    }

    /**
     * Manage the statuses of a repository
     * @link http://developer.github.com/v3/repos/statuses/
     *
     * @return Statuses
     */
    public function statuses()
    {
        return new Statuses($this->client);
    }

    /**
     * Get the branch(es) of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param  string  $username         the username
     * @param  string  $repository       the name of the repository
     * @param  string  $branch           the name of the branch
     *
     * @return array                     list of the repository branches
     */
    public function branches($username, $repository, $branch = null)
    {
        $url = 'repos/'.urlencode($username).'/'.urlencode($repository).'/branches';
        if (null !== $branch) {
            $url .= '/'.urlencode($branch);
        }

        return $this->get($url);
    }

    /**
     * Get the contributors of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param  string  $username           the user who owns the repository
     * @param  string  $repository         the name of the repository
     * @param  boolean $includingAnonymous by default, the list only shows GitHub users.
     *                                     You can include non-users too by setting this to true
     * @return array                       list of the repo contributors
     */
    public function contributors($username, $repository, $includingAnonymous = false)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/contributors', array(
            'anon' => $includingAnonymous ?: null
        ));
    }

    /**
     * Get the language breakdown of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param  string  $username         the user who owns the repository
     * @param  string  $repository       the name of the repository
     *
     * @return array                     list of the languages
     */
    public function languages($username, $repository)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/languages');
    }

    /**
     * Get the tags of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param  string  $username         the user who owns the repository
     * @param  string  $repository       the name of the repository
     *
     * @return array                     list of the repository tags
     */
    public function tags($username, $repository)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/tags');
    }

    /**
     * Get the teams of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository             the name of the repo
     *
     * @return array                     list of the languages
     */
    public function teams($username, $repository)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/teams');
    }

    /**
     * @param  string  $username
     * @param  string  $repository
     * @param  integer $page
     *
     * @return array
     */
    public function watchers($username, $repository, $page = 1)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/watchers', array(
            'page' => $page
        ));
    }
}
