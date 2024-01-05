<?php

namespace Github\Api\Organization;

use Github\Api\AbstractApi;

class Dependabot extends AbstractApi
{
    /**
     * @link https://docs.github.com/en/rest/dependabot/alerts?apiVersion=2022-11-28#list-dependabot-alerts-for-an-organization
     *
     * @param string $organization
     * @param array  $params
     *
     * @return array|string
     */
    public function alerts(string $organization, array $params = [])
    {
        return $this->get('/orgs/' . rawurlencode($organization) . '/dependabot/alerts', $params);
    }
}
