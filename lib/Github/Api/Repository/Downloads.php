<?php declare(strict_types=1);

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   http://developer.github.com/v3/repos/downloads/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Downloads extends AbstractApi
{
    /**
     * List downloads in selected repository.
     *
     * @link http://developer.github.com/v3/repos/downloads/#list-downloads-for-a-repository
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     */
    public function all(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/downloads');
    }

    /**
     * Get a download in selected repository.
     *
     * @link http://developer.github.com/v3/repos/downloads/#get-a-single-download
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param int    $id         the id of the download file
     */
    public function show(string $username, string $repository, int $id): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/downloads/'.rawurlencode((string) $id));
    }

    /**
     * Delete a download in selected repository.
     *
     * @link http://developer.github.com/v3/repos/downloads/#delete-a-download
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param int    $id         the id of the download file
     */
    public function remove(string $username, string $repository, int $id): array
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/downloads/'.rawurlencode((string) $id));
    }
}
