<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   http://developer.github.com/v3/repos/commits/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Commits extends AbstractApi
{
    public function all($username, $repository, array $params)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/commits', $params);
    }

    public function compare($username, $repository, $base, $head)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/compare/'.urlencode($base).'...'.urlencode($head));
    }

    public function show($username, $repository, $sha)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/commits/'.urlencode($sha));
    }
}
