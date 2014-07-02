<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   http://developer.github.com/v3/repos/downloads/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Downloads extends AbstractApi
{
    /**
     * List downloads in selected repository
     * @link http://developer.github.com/v3/repos/downloads/#list-downloads-for-a-repository
     *
     * @param  string $username   the user who owns the repo
     * @param  string $repository the name of the repo
     * @param  int    $page       the page
     * @param  int    $perPage    the number of results by page
     *
     * @return array
     */
    public function all($username, $repository, $page = 1, $perPage = 30)
    {
        $parameters = array(
            'page'     => $page,
            'per_page' => $perPage
        );

        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/downloads', $parameters);
    }

    /**
     * Get a download in selected repository
     * @link http://developer.github.com/v3/repos/downloads/#get-a-single-download
     *
     * @param string  $username   the user who owns the repo
     * @param string  $repository the name of the repo
     * @param integer $id         the id of the download file
     *
     * @return array
     */
    public function show($username, $repository, $id)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/downloads/'.rawurlencode($id));
    }

    /**
     * Delete a download in selected repository
     * @link http://developer.github.com/v3/repos/downloads/#delete-a-download
     *
     * @param string  $username   the user who owns the repo
     * @param string  $repository the name of the repo
     * @param integer $id         the id of the download file
     *
     * @return array
     */
    public function remove($username, $repository, $id)
    {
        return $this->delete('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/downloads/'.rawurlencode($id));
    }
}
