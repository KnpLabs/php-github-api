<?php declare(strict_types=1);

namespace Github\Api\GitData;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/git/blobs/
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Blobs extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the Accept header depending on the blob type.
     *
     * @param string|null $bodyType
     */
    public function configure(string $bodyType = null): self
    {
        if ('raw' === $bodyType) {
            $this->acceptHeaderValue = sprintf('application/vnd.github.%s.raw', $this->client->getApiVersion());
        }

        return $this;
    }

    /**
     * Show a blob of a sha for a repository.
     */
    public function show(string $username, string $repository, string $sha): array
    {
        $response = $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/blobs/'.rawurlencode($sha));

        return $response;
    }

    /**
     * Create a blob of a sha for a repository.
     *
     * @throws \Github\Exception\MissingArgumentException
     */
    public function create(string $username, string $repository, array $params): array
    {
        if (!isset($params['content'], $params['encoding'])) {
            throw new MissingArgumentException(['content', 'encoding']);
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/blobs', $params);
    }
}
