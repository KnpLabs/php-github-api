<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;

/**
 * @link   https://docs.github.com/rest/activity/starring#list-stargazers
 *
 * @author Nicolas Dupont <nicolas@akeneo.com>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Stargazers extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the body type to include star creation timestamps in the response.
     *
     * @see https://docs.github.com/rest/activity/starring#list-stargazers
     *
     * @param string $bodyType
     *
     * @return $this
     */
    public function configure($bodyType = null)
    {
        if ('star' === $bodyType) {
            $this->acceptHeaderValue = sprintf('application/vnd.github.%s.star+json', $this->getApiVersion());
        }

        return $this;
    }

    /**
     * List the people that have starred a repository.
     *
     * @link https://docs.github.com/rest/activity/starring#list-stargazers
     *
     * @param string $username   the username
     * @param string $repository the repository
     *
     * @return array
     */
    public function all($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stargazers');
    }
}
