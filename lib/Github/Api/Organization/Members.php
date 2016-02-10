<?php

namespace Github\Api\Organization;

use Github\Api\AbstractApi;

/**
 * @link   http://developer.github.com/v3/orgs/members/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Members extends AbstractApi
{
    public function all($organization, $type = null, $filter = 'all')
    {
        $parameters = array();
        $path = 'orgs/'.rawurlencode($organization).'/';
        if (null === $type) {
            $path .= 'members';
            if (null !== $filter) {
                $parameters['filter'] = $filter;
            }
        } else {
            $path .= 'public_members';
        }

        return $this->get($path, $parameters);
    }

    public function show($organization, $username)
    {
        return $this->get('orgs/'.rawurlencode($organization).'/members/'.rawurlencode($username));
    }

    public function check($organization, $username)
    {
        return $this->get('orgs/'.rawurlencode($organization).'/public_members/'.rawurlencode($username));
    }

    public function publicize($organization, $username)
    {
        return $this->put('orgs/'.rawurlencode($organization).'/public_members/'.rawurlencode($username));
    }

    public function conceal($organization, $username)
    {
        return $this->delete('orgs/'.rawurlencode($organization).'/public_members/'.rawurlencode($username));
    }

    /*
     * Add user to organization
     */
    public function add($organization, $username)
    {
        return $this->put('orgs/'.rawurlencode($organization).'/memberships/'.rawurlencode($username));
    }

    public function remove($organization, $username)
    {
        return $this->delete('orgs/'.rawurlencode($organization).'/members/'.rawurlencode($username));
    }
}
