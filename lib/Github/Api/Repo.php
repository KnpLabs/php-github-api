<?php

namespace Github\Api;

/**
 * Searching repositories, getting repository information
 * and managing repository information for authenticated users.
 *
 * @link      http://develop.github.com/p/repos.html
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class Repo extends Api
{
    /**
     * Search repositories by keyword:
     * @link http://developer.github.com/v3/search/#search-repositories
     *
     * @param   string  $keyword          the search query
     * @param   string  $language         takes the same values as the language drop down on http://github.com/search
     * @param   integer $startPage        the page number
     *
     * @return  array                     list of founded repositories
     */
    public function search($keyword, $language = null, $startPage = 1)
    {
        $url = 'legacy/repos/search/'.urlencode($keyword);

        $params = array();
        if (null !== $language) {
            $params['language'] = $language;
        }
        if (1 !== $startPage) {
            $params['start_page'] = $startPage;
        }

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $this->get($url);
    }

    /**
     * Get a list of the repositories that the authenticated user can push to
     *
     * @return  array  list of repositories
     */
    public function getPushableRepos()
    {
        throw new \BadMethodCallException('Method cannot be implemented using new api version');
    }

    /**
     * Get the repositories of a user
     * @link http://developer.github.com/v3/repos/
     *
     * @param   string  $username         the username
     * @return  array                     list of the user repos
     */
    public function getUserRepos($username)
    {
        return $this->get('users/'.urlencode($username).'/repos');
    }

    /**
     * Get extended information about a repository by its username and repo name
     * @link http://developer.github.com/v3/repos/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     informations about the repo
     */
    public function show($username, $repo)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo));
    }

    /**
     * Create repo
     * @link http://developer.github.com/v3/repos/
     *
     * @param   string  $name             name of the repository
     * @param   string  $description      repo description
     * @param   string  $homepage         homepage url
     * @param   bool    $public           1 for public, 0 for private
     * @return  array                     returns repo data
     */
    public function create($name, $description = '', $homepage = '', $public = true)
    {
        return $this->post('user/repos', array(
            'name' => $name,
            'description' => $description,
            'homepage' => $homepage,
            'private' => !$public
        ));
    }

    /**
     * Set information of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @param   array   $values           the key => value pairs to post
     * @return  array                     informations about the repo
     */
    public function setRepoInfo($username, $repo, $values)
    {
        return $this->patch('repos/'.urlencode($username).'/'.urlencode($repo), $values);
    }

    /**
     * Set the visibility of a repository to public
     * @link http://developer.github.com/v3/repos/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     informations about the repo
     */
    public function setPublic($username, $repo)
    {
        $this->setRepoInfo($username, $repo, array('private' => false));
    }

    /**
     * Set the visibility of a repository to private
     * @link http://developer.github.com/v3/repos/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     informations about the repo
     */
    public function setPrivate($username, $repo)
    {
        $this->setRepoInfo($username, $repo, array('private' => true));
    }

    /**
     * Get the list of deploy keys for a repository
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     the list of deploy keys
     */
    public function getDeployKeys($username, $repo)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/keys');
    }

    /**
     * Add a deploy key for a repository
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @param   string  $title            the title of the key
     * @param   string  $key              the public key data
     * @return  array                     the list of deploy keys
     */
    public function addDeployKey($username, $repo, $title, $key)
    {
        return $this->post('repos/'.urlencode($username).'/'.urlencode($repo).'/keys', array(
            'title' => $title,
            'key' => $key
        ));
    }

    /**
     * Delete a deploy key from a repository
     * @link http://developer.github.com/v3/repos/keys/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @param   string  $id               the the id of the key to remove
     * @return  array                     the list of deploy keys
     */
    public function removeDeployKey($username, $repo, $id)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repo).'/keys/'.urlencode($id));
    }

    /**
     * Get the collaborators of a repository
     * @link http://developer.github.com/v3/repos/collaborators/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     list of the repo collaborators
     */
    public function getRepoCollaborators($username, $repo)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/collaborators');
    }

    /**
     * Get the collaborator of a repository
     * @link http://developer.github.com/v3/repos/collaborators/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @param   string  $user             the user which we seek
     * @return  array                     list of the repo collaborators
     */
    public function getRepoCollaborator($username, $repo, $user)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/collaborators/'.urlencode($user));
    }

    /**
     * Add a collaborator to a repository
     * @link http://developer.github.com/v3/repos/collaborators/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @param   string  $user             the user who should be added as a collaborator
     * @return  array                     list of the repo collaborators
     */
    public function addRepoCollaborator($username, $repo, $user)
    {
        return $this->put('repos/'.urlencode($username).'/'.urlencode($repo).'/collaborators/'.urlencode($user));
    }

    /**
     * Delete a collaborator from a repository
     * @link http://developer.github.com/v3/repos/collaborators/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @param   string  $user             the user who should be removed as a collaborator
     * @return  array                     list of the repo collaborators
     */
    public function removeRepoCollaborator($repo, $username, $user)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repo).'/collaborators/'.urlencode($user));
    }

    /**
     * Make the authenticated user watch a repository
     * @link http://developer.github.com/v3/repos/watching/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     informations about the repo
     */
    public function watch($username, $repo)
    {
        return $this->put('user/watched/'.urlencode($username).'/'.urlencode($repo));
    }

    /**
     * Make the authenticated user unwatch a repository
     * @link http://developer.github.com/v3/repos/watching/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     informations about the repo
     */
    public function unwatch($username, $repo)
    {
        return $this->delete('user/watched/'.urlencode($username).'/'.urlencode($repo));
    }

    /**
     * Make the authenticated user fork a repository
     * @link http://developer.github.com/v3/repos/forks/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     informations about the newly forked repo
     */
    public function fork($username, $repo)
    {
        return $this->post('repos/'.urlencode($username).'/'.urlencode($repo).'/forks');
    }

    /**
     * Get the tags of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     list of the repo tags
     */
    public function getRepoTags($username, $repo)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/tags');
    }

    /**
     * Get the branches of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the name of the repo
     * @return  array                     list of the repo branches
     */
    public function getRepoBranches($username, $repo)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/branches');
    }

    /**
     * Get the watchers of a repository
     * @link http://developer.github.com/v3/repos/watching/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     list of the repo watchers
     */
    public function getRepoWatchers($username, $repo)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/watchers');
    }

    /**
     * Get the network (a list of forks) of a repository
     * http://develop.github.com/p/repo.html
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     list of the repo forks
     */
    public function getRepoNetwork($username, $repo)
    {
        throw new \BadMethodCallException('Method cannot be implemented using new api version');
    }

    /**
     * Get the language breakdown of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @return  array                     list of the languages
     */
    public function getRepoLanguages($username, $repo)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/languages');
    }

    /**
     * Get the contributors of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param   string  $username         the user who owns the repo
     * @param   string  $repo             the name of the repo
     * @param   boolean $includingAnonymous by default, the list only shows GitHub users. You can include non-users too by setting this to true
     * @return  array                     list of the repo contributors
     */
    public function getRepoContributors($username, $repo, $includingAnonymous = false)
    {
        $url = 'repos/'.urlencode($username).'/'.urlencode($repo).'/contributors';
        if ($includingAnonymous) {
            $url .= '?anon=1';
        }

        return $this->get($url);
    }

    /**
     * Get the teams of a repository
     * @link http://developer.github.com/v3/repos/
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repo             the name of the repo
     *
     * @return array                     list of the languages
     */
    public function getRepoTeams($username, $repo)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/teams');
    }

    /**
     * Get contents of any file or directory in a repository
     * @link http://developer.github.com/v3/repos/contents/
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repo             the name of the repo
     * @param  string  $path             path to file or directory
     *
     * @return array                     information for file | information for each item in directory
     */
    public function getRepoContents($username, $repo, $path)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/contents/'.$path);
    }

    /**
     * Get the downloads for selected repository
     * @link http://developer.github.com/v3/repos/downloads/#list-downloads-for-a-repository
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repo             the name of the repo
     *
     * @return array
     */
    public function getRepoDownloads($username, $repo)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/downloads');
    }

    /**
     * Delete a download in selected repository
     * @link http://developer.github.com/v3/repos/downloads/#delete-a-download
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repo             the name of the repo
     * @param  integer $id               the id of the download file
     *
     * @return array
     */
    public function deleteRepoDownload($username, $repo, $id)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repo).'/downloads/'.urlencode($id));
    }

    /**
     * Get the hooks for selected repository
     * @link http://developer.github.com/v3/repos/hooks/#list
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repo             the name of the repo
     *
     * @return array
     */
    public function getRepoHooks($username, $repo)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/hooks');
    }
}
