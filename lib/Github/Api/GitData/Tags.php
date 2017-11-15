<?php declare(strict_types=1);

namespace Github\Api\GitData;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/git/tags/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Tags extends AbstractApi
{
    /**
     * Get all tags for a repository.
     */
    public function all(string $username, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs/tags');
    }

    /**
     * Get a tag for a repository.
     */
    public function show(string $username, string $repository, string $sha): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/tags/'.rawurlencode($sha));
    }

    /**
     * Create a tag for a repository.
     *
     *
     *
     * @throws \Github\Exception\MissingArgumentException
     */
    public function create(string $username, string $repository, array $params): array
    {
        if (!isset($params['tag'], $params['message'], $params['object'], $params['type'])) {
            throw new MissingArgumentException(['tag', 'message', 'object', 'type']);
        }

        if (!isset($params['tagger'])) {
            throw new MissingArgumentException('tagger');
        }

        if (!isset($params['tagger']['name'], $params['tagger']['email'], $params['tagger']['date'])) {
            throw new MissingArgumentException(['tagger.name', 'tagger.email', 'tagger.date']);
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/tags', $params);
    }
}
