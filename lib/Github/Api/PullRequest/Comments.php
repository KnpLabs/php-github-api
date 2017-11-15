<?php declare(strict_types=1);

namespace Github\Api\PullRequest;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/pulls/comments/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Comments extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the body type.
     *
     * @link https://developer.github.com/v3/pulls/comments/#custom-media-types
     * @param string|null $bodyType
     * @param string|null @apiVersion
     */
    public function configure(string $bodyType = null, string $apiVersion = null): self
    {
        if (!in_array($apiVersion, ['squirrel-girl-preview'])) {
            $apiVersion = $this->client->getApiVersion();
        }

        if (!in_array($bodyType, ['text', 'html', 'full'])) {
            $bodyType = 'raw';
        }

        $this->acceptHeaderValue = sprintf('application/vnd.github.%s.%s+json', $apiVersion, $bodyType);

        return $this;
    }

    /**
     * Get a listing of a pull request's comments by the username, repository and pull request number
     * or all repository comments by the username and repository.
     *
     * @link https://developer.github.com/v3/pulls/comments/#list-comments-on-a-pull-request
     * @link https://developer.github.com/v3/pulls/comments/#list-comments-in-a-repository
     *
     * @param string   $username    the username
     * @param string   $repository  the repository
     * @param int|null $pullRequest the pull request number
     * @param array    $params      a list of extra parameters.
     */
    public function all(string $username, string $repository, int $pullRequest = null, array $params = []): array
    {
        if (null !== $pullRequest) {
            return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.rawurlencode($pullRequest).'/comments');
        }

        $parameters = array_merge([
            'page' => 1,
            'per_page' => 30
        ], $params);

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/comments', $parameters);
    }

    /**
     * Get a single pull request comment by the username, repository and comment id.
     *
     * @link https://developer.github.com/v3/pulls/comments/#get-a-single-comment
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param int    $comment    the comment id
     */
    public function show(string $username, string $repository, int $comment): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/comments/'.rawurlencode($comment));
    }

    /**
     * Create a pull request comment by the username, repository and pull request number.
     *
     * @link https://developer.github.com/v3/pulls/comments/#create-a-comment
     *
     * @param string $username    the username
     * @param string $repository  the repository
     * @param int    $pullRequest the pull request number
     * @param array  $params      a list of extra parameters.
     *
     * @throws MissingArgumentException
     */
    public function create(string $username, string $repository, int $pullRequest, array $params): array
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        // If `in_reply_to` is set, other options are not necessary anymore
        if (!isset($params['in_reply_to']) && !isset($params['commit_id'], $params['path'], $params['position'])) {
            throw new MissingArgumentException(['commit_id', 'path', 'position']);
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.rawurlencode($pullRequest).'/comments', $params);
    }

    /**
     * Update a pull request comment by the username, repository and comment id.
     *
     * @link https://developer.github.com/v3/pulls/comments/#edit-a-comment
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param int    $comment    the comment id
     * @param array  $params     a list of extra parameters.
     *
     * @throws MissingArgumentException
     */
    public function update(string $username, string $repository, int $comment, array $params): array
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/comments/'.rawurlencode($comment), $params);
    }

    /**
     * Delete a pull request comment by the username, repository and comment id.
     *
     * @link https://developer.github.com/v3/pulls/comments/#delete-a-comment
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param int    $comment    the comment id
     */
    public function remove(string $username, string $repository, int $comment): string
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/comments/'.rawurlencode($comment));
    }
}
