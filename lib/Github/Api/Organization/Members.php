<?php

namespace Github\Api\Organization;

use Github\Api\AbstractApi;

/**
 * @link   http://developer.github.com/v3/orgs/members/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Members extends AbstractApi
{
    public function all($organization, $type = null)
    {
        if (null === $type) {
            return $this->get('orgs/'.urlencode($organization).'/members');
        }

        return $this->get('orgs/'.urlencode($organization).'/public_members');
    }

    public function show($organization, $username)
    {
        return $this->get('orgs/'.urlencode($organization).'/members/'.urlencode($username));
    }

    public function check($organization, $username)
    {
        return $this->get('orgs/'.urlencode($organization).'/public_members/'.urlencode($username));
    }

    public function publicize($organization, $username)
    {
        return $this->put('orgs/'.urlencode($organization).'/public_members/'.urlencode($username));
    }

    public function conceal($organization, $username)
    {
        return $this->delete('orgs/'.urlencode($organization).'/public_members/'.urlencode($username));
    }

    public function remove($organization, $username)
    {
        return $this->delete('orgs/'.urlencode($organization).'/members/'.urlencode($username));
    }
}
