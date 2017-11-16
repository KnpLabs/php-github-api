<?php declare(strict_types=1);

namespace Github\Api;

use Github\Api\Enterprise\License;
use Github\Api\Enterprise\ManagementConsole;
use Github\Api\Enterprise\Stats;
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
    public function stats(): Stats
    {
        return new Stats($this->client);
    }

    public function license(): License
    {
        return new License($this->client);
    }

    public function console(): ManagementConsole
    {
        return new ManagementConsole($this->client);
    }

    public function userAdmin(): UserAdmin
    {
        return new UserAdmin($this->client);
    }
}
