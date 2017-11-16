<?php declare(strict_types=1);

namespace Github\Api;

use Github\Api\Enterprise\ManagementConsole;
use Github\Api\Enterprise\Stats;
use Github\Api\Enterprise\License;
use Github\Api\Enterprise\UserAdmin;

/**
 * Getting information about a GitHub Enterprise instance.
 *
 * @link   https://developer.github.com/v3/enterprise/
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Guillermo A. Fisher <guillermoandraefisher@gmail.com>
 */
class Enterprise extends AbstractApi
{
    /**
     * @return Stats
     */
    public function stats(): Stats
    {
        return new Stats($this->client);
    }

    /**
     * @return License
     */
    public function license(): License
    {
        return new License($this->client);
    }

    /**
     * @return ManagementConsole
     */
    public function console(): ManagementConsole
    {
        return new ManagementConsole($this->client);
    }

    /**
     * @return UserAdmin
     */
    public function userAdmin(): UserAdmin
    {
        return new UserAdmin($this->client);
    }
}
