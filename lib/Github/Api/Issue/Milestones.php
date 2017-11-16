<?php declare(strict_types=1);

namespace Github\Api\Issue;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/issues/milestones/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Milestones extends AbstractApi
{
    /**
     * Get all milestones for a repository.
     *
     * @link https://developer.github.com/v3/issues/milestones/#list-milestones-for-a-repository
     * @param string $username
     * @param string $repository
     * @param array  $params
     *
     * @return array
     */
    public function all(string $username, string $repository, array $params = []): array
    {
        if (isset($params['state']) && !in_array($params['state'], ['open', 'closed', 'all'])) {
            $params['state'] = 'open';
        }
        if (isset($params['sort']) && !in_array($params['sort'], ['due_date', 'completeness'])) {
            $params['sort'] = 'due_date';
        }
        if (isset($params['direction']) && !in_array($params['direction'], ['asc', 'desc'])) {
            $params['direction'] = 'asc';
        }

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/milestones', array_merge([
            'page'      => 1,
            'state'     => 'open',
            'sort'      => 'due_date',
            'direction' => 'asc'
        ], $params));
    }

    /**
     * Get a milestone for a repository.
     *
     * @link https://developer.github.com/v3/issues/milestones/#get-a-single-milestone
     * @param string $username
     * @param string $repository
     * @param int    $id
     *
     * @return array
     */
    public function show(string $username, string $repository, int $id): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/milestones/'.rawurlencode((string) $id));
    }

    /**
     * Create a milestone for a repository.
     *
     * @link https://developer.github.com/v3/issues/milestones/#create-a-milestone
     * @param string $username
     * @param string $repository
     * @param array  $params
     *
     * @return array
     *
     * @throws \Github\Exception\MissingArgumentException
     */
    public function create(string $username, string $repository, array $params): array
    {
        if (!isset($params['title'])) {
            throw new MissingArgumentException('title');
        }
        if (isset($params['state']) && !in_array($params['state'], ['open', 'closed'])) {
            $params['state'] = 'open';
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/milestones', $params);
    }

    /**
     * Update a milestone for a repository.
     *
     * @link https://developer.github.com/v3/issues/milestones/#update-a-milestone
     * @param string $username
     * @param string $repository
     * @param int    $id
     * @param array  $params
     *
     * @return array
     */
    public function update(string $username, string $repository, int $id, array $params): array
    {
        if (isset($params['state']) && !in_array($params['state'], ['open', 'closed'])) {
            $params['state'] = 'open';
        }

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/milestones/'.rawurlencode((string) $id), $params);
    }

    /**
     * Delete a milestone for a repository.
     *
     * @link https://developer.github.com/v3/issues/milestones/#delete-a-milestone
     * @param string $username
     * @param string $repository
     * @param int    $id
     *
     * @return null
     */
    public function remove(string $username, string $repository, int $id)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/milestones/'.rawurlencode((string) $id));
    }

    /**
     * Get the labels of a milestone
     *
     * @link https://developer.github.com/v3/issues/labels/#get-labels-for-every-issue-in-a-milestone
     * @param string $username
     * @param string $repository
     * @param int    $id
     *
     * @return array
     */
    public function labels(string $username, string $repository, int $id): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/milestones/'.rawurlencode((string) $id).'/labels');
    }
}
