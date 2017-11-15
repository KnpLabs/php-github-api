<?php declare(strict_types=1);

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/repos/statuses/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Statuses extends AbstractApi
{
    /**
     * @link http://developer.github.com/v3/repos/statuses/#list-statuses-for-a-specific-sha
     */
    public function show(string $username, string $repository, string $sha): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($sha).'/statuses');
    }

    /**
     * @link https://developer.github.com/v3/repos/statuses/#get-the-combined-status-for-a-specific-ref
     */
    public function combined(string $username, string $repository, string $sha): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($sha).'/status');
    }

    /**
     * @link http://developer.github.com/v3/repos/statuses/#create-a-status
     *
     *
     * @throws MissingArgumentException
     */
    public function create(string $username, string $repository, string $sha, array $params = []): array
    {
        if (!isset($params['state'])) {
            throw new MissingArgumentException('state');
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/statuses/'.rawurlencode($sha), $params);
    }
}
