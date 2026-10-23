<?php

namespace Github\Api\CurrentUser;

use Github\Api\AbstractApi;

class Memberships extends AbstractApi
{
    /**
     * List your organization memberships.
     *
     * @link https://docs.github.com/rest/orgs/members#list-organization-memberships-for-the-authenticated-user
     *
     * @return array
     */
    public function all()
    {
        return $this->get('/user/memberships/orgs');
    }

    /**
     * Get your organization membership.
     *
     * @link https://docs.github.com/rest/orgs/members#get-an-organization-membership-for-the-authenticated-user
     *
     * @param string $organization
     *
     * @return array
     */
    public function organization($organization)
    {
        return $this->get('/user/memberships/orgs/'.rawurlencode($organization));
    }

    /**
     * Edit your organization membership.
     *
     * @link https://docs.github.com/rest/orgs/members#update-an-organization-membership-for-the-authenticated-user
     *
     * @param string $organization
     *
     * @return array
     */
    public function edit($organization)
    {
        return $this->patch('/user/memberships/orgs/'.rawurlencode($organization), ['state' => 'active']);
    }
}
