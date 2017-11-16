<?php declare(strict_types=1);

namespace Github\Api\CurrentUser;

use Github\Api\AbstractApi;

class Memberships extends AbstractApi
{
    /**
     * List your organization memberships.
     *
     * @link https://developer.github.com/v3/orgs/members/#get-your-organization-membership
     *
     * @return array
     */
    public function all(): array
    {
        return $this->get('/user/memberships/orgs');
    }

    /**
     * Get your organization membership.
     *
     * @link https://developer.github.com/v3/orgs/members/#get-your-organization-membership
     *
     * @param string $organization
     *
     * @return array
     */
    public function organization(string $organization): array
    {
        return $this->get('/user/memberships/orgs/'.rawurlencode($organization));
    }

    /**
     * Edit your organization membership
     *
     * @link https://developer.github.com/v3/orgs/members/#edit-your-organization-membership
     *
     * @param string $organization
     *
     * @return array
     */
    public function edit(string $organization): array
    {
        return $this->patch('/user/memberships/orgs/'.rawurlencode($organization), ['state' => 'active']);
    }
}
