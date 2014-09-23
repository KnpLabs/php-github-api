<?php

namespace Github\Api;

use Github\Api\Enterprise\Stats;
use Github\Api\Enterprise\License;

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
    public function stats()
    {
        return new Stats($this->client);
    }

    /**
     * @return License
     */
    public function license()
    {
        return new License($this->client);
    }
}
