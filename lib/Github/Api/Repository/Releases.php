<?php declare(strict_types=1);

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/repos/releases/
 * @author Matthew Simo <matthew.a.simo@gmail.com>
 * @author Evgeniy Guseletov <d46k16@gmail.com>
 */
class Releases extends AbstractApi
{
    /**
     * Get the latest release.
     */
    public function latest($username, $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/latest');
    }

    /**
     * List releases for a tag.
     */
    public function tag($username, $repository, $tag): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/tags/'.rawurlencode($tag));
    }

    /**
     * List releases in selected repository.
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param array  $params     the additional parameters like milestone, assignees, labels, sort, direction
     */
    public function all(string $username, string $repository, array $params = []): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases', $params);
    }

    /**
     * Get a release in selected repository.
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param int    $id         the id of the release
     */
    public function show(string $username, string $repository, int $id): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/'.rawurlencode((string) $id));
    }

    /**
     * Create new release in selected repository.
     *
     * @throws MissingArgumentException
     */
    public function create(string $username, string $repository, array $params): array
    {
        if (!isset($params['tag_name'])) {
            throw new MissingArgumentException('tag_name');
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases', $params);
    }

    /**
     * Edit release in selected repository.
     */
    public function edit(string $username, string $repository, int $id, array $params): array
    {
        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/'.rawurlencode((string) $id), $params);
    }

    /**
     * Delete a release in selected repository (Not thoroughly tested!).
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param int    $id         the id of the release
     */
    public function remove(string $username, string $repository, int $id): array
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/'.rawurlencode((string) $id));
    }

    public function assets(): Assets
    {
        return new Assets($this->client);
    }
}
