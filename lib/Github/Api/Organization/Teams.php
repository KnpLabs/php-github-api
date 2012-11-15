<?php

namespace Github\Api\Organization;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/orgs/teams/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Teams extends AbstractApi
{
    public function all($organization)
    {
        return $this->get('orgs/'.urlencode($organization).'/teams');
    }

    public function create($organization, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException('name');
        }
        if (isset($params['repo_names']) && !is_array($params['repo_names'])) {
            $params['repo_names'] = array($params['repo_names']);
        }
        if (isset($params['permission']) && !in_array($params['permission'], array('pull', 'push', 'admin'))) {
            $params['permission'] = 'pull';
        }

        return $this->post('orgs/'.urlencode($organization).'/teams', $params);
    }

    public function show($team)
    {
        return $this->get('teams/'.urlencode($team));
    }

    public function update($team, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException('name');
        }
        if (isset($params['permission']) && !in_array($params['permission'], array('pull', 'push', 'admin'))) {
            $params['permission'] = 'pull';
        }

        return $this->patch('teams/'.urlencode($team), $params);
    }

    public function remove($team)
    {
        return $this->delete('teams/'.urlencode($team));
    }

    public function members($team)
    {
        return $this->get('teams/'.urlencode($team).'/members');
    }

    public function check($team, $username)
    {
        return $this->get('teams/'.urlencode($team).'/members/'.urlencode($username));
    }

    public function addMember($team, $username)
    {
        return $this->put('teams/'.urlencode($team).'/members/'.urlencode($username));
    }

    public function removeMember($team, $username)
    {
        return $this->delete('teams/'.urlencode($team).'/members/'.urlencode($username));
    }

    public function repositories($team)
    {
        return $this->get('teams/'.urlencode($team).'/repos');
    }

    public function repository($team, $username, $repository)
    {
        return $this->get('teams/'.urlencode($team).'/repos/'.urlencode($username).'/'.urlencode($repository));
    }

    public function addRepository($team, $username, $repository)
    {
        return $this->put('teams/'.urlencode($team).'/repos/'.urlencode($username).'/'.urlencode($repository));
    }

    public function removeRepository($team, $username, $repository)
    {
        return $this->delete('teams/'.urlencode($team).'/repos/'.urlencode($username).'/'.urlencode($repository));
    }
}
