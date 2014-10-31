<?php
/**
 * This file is part of the php-github-api package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Github\Api\Enterprise;

use Github\Api\AbstractApi;

class ManagementConsole extends AbstractApi
{
    /**
     * Checks the status of your installation’s most recent configuration process.
     * @link https://developer.github.com/v3/enterprise/management_console/#check-configuration-status
     *
     * @param string $hash md5 hash of your license
     * @return array array of configuration status information
     */
    public function configcheck($hash)
    {
        return $this->get('/setup/api/configcheck', $hash);
    }

    /**
     * Retrieves your installation’s settings.
     * @link https://developer.github.com/v3/enterprise/management_console/#retrieve-settings
     *
     * @param string $hash md5 hash of your license
     * @return array array of settings
     */
    public function settings($hash)
    {
        return $this->get('/setup/api/settings', $hash);
    }

    /**
     * Checks your installation’s maintenance status.
     * @link https://developer.github.com/v3/enterprise/management_console/#check-maintenance-status
     *
     * @param string $hash md5 hash of your license
     * @return array array of maintenance status information
     */
    public function maintenance($hash)
    {
        return $this->get('/setup/api/maintenance', $hash);
    }

    /**
     * Retrieves your installation’s authorized SSH keys.
     * @link https://developer.github.com/v3/enterprise/management_console/#retrieve-authorized-ssh-keys
     *
     * @param string $hash md5 hash of your license
     * @return array array of authorized keys
     */
    public function keys($hash)
    {
        return $this->get('/setup/api/settings/authorized-keys', $hash);
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * Sends an authenticated GET request.
     *
     * @see \Github\Api\AbstractApi::get()
     * @param string $uri
     * @param array $hash
     * @return \Guzzle\Http\EntityBodyInterface|mixed|string
     */
    protected function get($uri, $hash)
    {
        return parent::get($uri, array('auth' => array('license', rawurlencode($hash))));
    }
}
