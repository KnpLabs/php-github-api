<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @author Matthew Simo <matthew.a.simo@gmail.com>
 */
class Releases extends AbstractApi
{
    /**
     * List releases in selected repository
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     *
     * @return array
     */
    public function all($username, $repository)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/releases');
    }

    /**
     * Get a release in selected repository
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     * @param  integer $id               the id of the release 
     *
     * @return array
     */
    public function show($username, $repository, $id)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/releases/'.urlencode($id));
    }

    /**
     * Delete a download in selected repository (Not thoroughly tested!)
     *
     * @param  string  $username         the user who owns the repo
     * @param  string  $repository       the name of the repo
     * @param  integer $id               the id of the release 
     *
     * @return array
     */
    public function remove($username, $repository, $id)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repository).'/releases/'.urlencode($id));
    }
}
