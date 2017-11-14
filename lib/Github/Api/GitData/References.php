<?php declare(strict_types=1);

namespace Github\Api\GitData;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/git/references/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class References extends AbstractApi
{
    /**
     * Get all references of a repository.
     *
     * @param string $username
     * @param string $repository
     *
     * @return array
     */
    public function all(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs');
    }

    /**
     * Get all branches of a repository.
     *
     * @param string $username
     * @param string $repository
     *
     * @return array
     */
    public function branches(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs/heads');
    }

    /**
     * Get all tags of a repository.
     *
     * @param string $username
     * @param string $repository
     *
     * @return array
     */
    public function tags(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs/tags');
    }

    /**
     * Show the reference of a repository.
     *
     * @param string $username
     * @param string $repository
     * @param string $reference
     *
     * @return array
     */
    public function show(string $username, string $repository, string $reference): array
    {
        $reference = $this->encodeReference($reference);

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs/'.$reference);
    }

    /**
     * Create a reference for a repository.
     *
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
        if (!isset($params['ref'], $params['sha'])) {
            throw new MissingArgumentException(['ref', 'sha']);
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs', $params);
    }

    /**
     * Update a reference for a repository.
     *
     * @param string $username
     * @param string $repository
     * @param string $reference
     * @param array  $params
     *
     * @return array
     *
     * @throws \Github\Exception\MissingArgumentException
     */
    public function update(string $username, string $repository, string $reference, array $params): array
    {
        if (!isset($params['sha'])) {
            throw new MissingArgumentException('sha');
        }

        $reference = $this->encodeReference($reference);

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs/'.$reference, $params);
    }

    /**
     * Delete a reference of a repository.
     *
     * @param string $username
     * @param string $repository
     * @param string $reference
     *
     * @return array
     */
    public function remove(string $username, string $repository, string $reference): array
    {
        $reference = $this->encodeReference($reference);

        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs/'.$reference);
    }

    /**
     * Encode the raw reference.
     *
     * @param string $rawReference
     *
     * @return string
     */
    private function encodeReference(string $rawReference): string
    {
        return implode('/', array_map('rawurlencode', explode('/', $rawReference)));
    }
}
