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
     * @link http://developer.github.com/v3/repos/downloads/
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     *
     * @return array
     */
    public function all($username, $repository)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/downloads');
    }

    /**
     * Get a download in selected repository
     * @link http://developer.github.com/v3/repos/downloads/
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     * @param  integer $id               the id of the download file
     *
     * @return array
     */
    public function show($username, $repository, $id)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/downloads/'.urlencode($id));
    }

    /**
     * Delete a download in selected repository
     * @link http://developer.github.com/v3/repos/downloads/#delete-a-download
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     * @param  integer $id               the id of the download file
     *
     * @return array
     */
    public function remove($username, $repository, $id)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repository).'/downloads/'.urlencode($id));
    }
}
