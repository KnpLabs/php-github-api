<?php declare(strict_types=1);

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/repos/comments/
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Comments extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the body type.
     *
     * @link https://developer.github.com/v3/repos/comments/#custom-media-types
     * @param string|null $bodyType
     */
    public function configure(string $bodyType = null): self
    {
        if (!in_array($bodyType, ['raw', 'text', 'html'])) {
            $bodyType = 'full';
        }

        $this->acceptHeaderValue = sprintf('application/vnd.github.%s.%s+json', $this->client->getApiVersion(), $bodyType);

        return $this;
    }

    public function all($username, $repository, $sha = null)
    {
        if (null === $sha) {
            return $this->get('/repos/'.rawurlencode((string) $username).'/'.rawurlencode((string) $repository).'/comments');
        }

        return $this->get('/repos/'.rawurlencode((string) $username).'/'.rawurlencode((string) $repository).'/commits/'.rawurlencode((string) $sha).'/comments');
    }

    public function show($username, $repository, $comment)
    {
        return $this->get('/repos/'.rawurlencode((string) $username).'/'.rawurlencode((string) $repository).'/comments/'.rawurlencode((string) $comment));
    }

    public function create($username, $repository, $sha, array $params)
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->post('/repos/'.rawurlencode((string) $username).'/'.rawurlencode((string) $repository).'/commits/'.rawurlencode((string) $sha).'/comments', $params);
    }

    public function update($username, $repository, $comment, array $params)
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->patch('/repos/'.rawurlencode((string) $username).'/'.rawurlencode((string) $repository).'/comments/'.rawurlencode((string) $comment), $params);
    }

    public function remove($username, $repository, $comment)
    {
        return $this->delete('/repos/'.rawurlencode((string) $username).'/'.rawurlencode((string) $repository).'/comments/'.rawurlencode((string) $comment));
    }
}
