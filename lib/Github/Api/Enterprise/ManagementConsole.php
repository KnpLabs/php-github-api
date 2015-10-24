<?php

namespace Github\Api\Enterprise;

use Github\Api\AbstractApi;

class ManagementConsole extends AbstractApi
{
    /**
     * Checks the status of your installation’s most recent configuration process.
     *
     * @link https://developer.github.com/v3/enterprise/management_console/#check-configuration-status
     *
     * @param string $password the password for the management console
     *
     * @return array array of configuration status information
     */
    public function configcheck($password)
    {
        return $this->getWithLicenseHash('/setup/api/configcheck', $password);
    }

    /**
     * Retrieves your installation’s settings.
     *
     * @link https://developer.github.com/v3/enterprise/management_console/#retrieve-settings
     *
     * @param string $password the password for the management console
     *
     * @return array array of settings
     */
    public function settings($password)
    {
        return $this->getWithLicenseHash('/setup/api/settings', $password);
    }

    /**
     * Checks your installation’s maintenance status.
     *
     * @link https://developer.github.com/v3/enterprise/management_console/#check-maintenance-status
     *
     * @param string $password the password for the management console
     *
     * @return array array of maintenance status information
     */
    public function maintenance($password)
    {
        return $this->getWithLicenseHash('/setup/api/maintenance', $password);
    }

    /**
     * Retrieves your installation’s authorized SSH keys.
     *
     * @link https://developer.github.com/v3/enterprise/management_console/#retrieve-authorized-ssh-keys
     *
     * @param string $password the password for the management console
     *
     * @return array array of authorized keys
     */
    public function keys($password)
    {
        return $this->getWithLicenseHash('/setup/api/settings/authorized-keys', $password);
    }

    /**
     * Sends an authenticated GET request.
     *
     * @param string $uri  the request URI
     * @param string $password the password for the management console
     *
     * @return \Guzzle\Http\EntityBodyInterface|mixed|string
     */
    protected function getWithLicenseHash($uri, $password)
    {
        return $this->get($uri, array('api_key' => rawurlencode($password)));
    }
}
