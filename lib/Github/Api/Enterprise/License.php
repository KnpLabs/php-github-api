<?php

namespace Github\Api\Enterprise;

use Github\Api\AbstractApi;

class License extends AbstractApi
{
    /**
     * Provides information about your Enterprise license (only available to site admins).
     *
     * @link https://docs.github.com/enterprise-server@3.14/rest/enterprise-admin/license#get-license-information
     *
     * @return array array of license information
     */
    public function show()
    {
        return $this->get('/enterprise/settings/license');
    }
}
