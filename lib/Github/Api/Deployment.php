<?php

namespace Github\Api;

use Github\Exception\MissingArgumentException;

class Deployment extends AbstractApi
{

    public function all($username, $repository, array $params = array())
    {   
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/deployments', array(),
          array('Accept' => 'application/vnd.github.cannonball-preview+json')
        );
    }



    /**
     * Create a new deployment for the given username and repo.
     *
     * @param  string $username   the username
     * @param  string $repository the repository
     * @param  array  $params     the new deployment data
     * @return array  information about the deployment
     *
     * @throws MissingArgumentException
     */
    public function create($username, $repository, array $params)
    {
         if (!isset($params['ref'])) {
             throw new MissingArgumentException(array('ref'));
         }

         return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/deployments', $params, ['Accept' => 'application/vnd.github.cannonball-preview+json']);
    }

    /**
     * Update deployment information's by username, repo and deployment number. Requires authentication.
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param string $id         the deployment number
     * @return array information about the deployment
     */
    public function update($username, $repository, $id, array $params)
    {
         if (!isset($params['state'])) {
           throw new MissingArgumentException(array('state'));
         }
         return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/deployments/'.rawurlencode($id).'/statuses', $params, ['Accept' => 'application/vnd.github.cannonball-preview+json']);
    }
}
