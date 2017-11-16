<?php declare(strict_types=1);

namespace Github\Api\Issue;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/issues/comments/
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Comments extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the body type.
     *
     * @link https://developer.github.com/v3/issues/comments/#custom-media-types
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

    /**
     * Get all comments for an issue.
     *
     * @link https://developer.github.com/v3/issues/comments/#list-comments-on-an-issue
     */
    public function all(string $username, string $repository, int $issue, int $page = 1): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/comments', [
            'page' => $page
        ]);
    }

    /**
     * Get a comment for an issue.
     *
     * @link https://developer.github.com/v3/issues/comments/#get-a-single-comment
     */
    public function show(string $username, string $repository, int $comment): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/comments/'.rawurlencode($comment));
    }

    /**
     * Create a comment for an issue.
     *
     * @link https://developer.github.com/v3/issues/comments/#create-a-comment
     *
     * @param string|int $issue
     *
     * @throws \Github\Exception\MissingArgumentException
     */
    public function create(string $username, string $repository, $issue, array $params): array
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode((string) $issue).'/comments', $params);
    }

    /**
     * Update a comment for an issue.
     *
     * @link https://developer.github.com/v3/issues/comments/#edit-a-comment
     *
     * @param string|int $issue
     *
     * @throws \Github\Exception\MissingArgumentException
     */
    public function update(string $username, string $repository, $comment, array $params): array
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/comments/'.rawurlencode((string) $comment), $params);
    }

    /**
     * Delete a comment for an issue.
     *
     * @param string|int $issue
     *
     * @link https://developer.github.com/v3/issues/comments/#delete-a-comment
     */
    public function remove(string $username, string $repository, $comment): array
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/comments/'.rawurlencode((string) $comment));
    }
}
