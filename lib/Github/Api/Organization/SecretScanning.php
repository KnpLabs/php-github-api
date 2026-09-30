<?php

namespace Github\Api\Organization;

class SecretScanning extends \Github\Api\AbstractApi
{
    /**
     * @link https://docs.github.com/rest/secret-scanning/secret-scanning#list-secret-scanning-alerts-for-an-organization
     *
     * @param string $organization
     * @param array  $params
     *
     * @return array|string
     */
    public function alerts(string $organization, array $params = [])
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/secret-scanning/alerts', $params);
    }
}
