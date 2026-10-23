<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;

/**
 * @link   https://docs.github.com/rest/pages/pages
 *
 * @author yunwuxin <tzzhangyajun@qq.com>
 */
class Pages extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Get a GitHub Pages site for a repository.
     *
     * @link https://docs.github.com/rest/pages/pages#get-a-github-pages-site
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array
     */
    public function show($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pages');
    }

    /**
     * Create a GitHub Pages site for a repository.
     *
     * @link https://docs.github.com/rest/pages/pages#create-a-github-pages-site
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     the parameters (build_type, source)
     *
     * @return array
     */
    public function enable($username, $repository, array $params = [])
    {
        $this->acceptHeaderValue = 'application/vnd.github.switcheroo-preview+json';

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pages', $params);
    }

    /**
     * Delete a GitHub Pages site for a repository.
     *
     * @link https://docs.github.com/rest/pages/pages#delete-a-github-pages-site
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array
     */
    public function disable($username, $repository)
    {
        $this->acceptHeaderValue = 'application/vnd.github.switcheroo-preview+json';

        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pages');
    }

    /**
     * Update information about a GitHub Pages site for a repository.
     *
     * @link https://docs.github.com/rest/pages/pages#update-information-about-a-github-pages-site
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param array  $params     the parameters to update (build_type, source, cname, https_enforced, public)
     *
     * @return array
     */
    public function update($username, $repository, array $params = [])
    {
        return $this->put('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pages', $params);
    }

    /**
     * Request a GitHub Pages build for a repository.
     *
     * @link https://docs.github.com/rest/pages/pages#request-a-github-pages-build
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array
     */
    public function requestBuild($username, $repository)
    {
        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pages/builds');
    }

    /**
     * List GitHub Pages builds for a repository.
     *
     * @link https://docs.github.com/rest/pages/pages#list-github-pages-builds
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array
     */
    public function builds($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pages/builds');
    }

    /**
     * Get the latest GitHub Pages build for a repository.
     *
     * @link https://docs.github.com/rest/pages/pages#get-latest-pages-build
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array
     */
    public function showLatestBuild($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pages/builds/latest');
    }

    /**
     * Get a GitHub Pages build for a repository.
     *
     * @link https://docs.github.com/rest/pages/pages#get-github-pages-build
     *
     * @param string     $username   the username
     * @param string     $repository the repository
     * @param int|string $id         the id of the pages build
     *
     * @return array
     */
    public function showBuild($username, $repository, $id)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pages/builds/'.rawurlencode($id));
    }
}
