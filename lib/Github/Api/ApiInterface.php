<?php

namespace Github\Api;

use Github\Client;

/**
 * Api interface
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
interface ApiInterface
{
    public function __construct(Client $client);

    public function getPerPage();

    public function setPerPage($perPage);
}
