<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

/**
 * @link   https://docs.github.com/rest/commits/comments
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Comments extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the body type.
     *
     * @link https://docs.github.com/rest/using-the-rest-api/getting-started-with-the-rest-api#media-types
     *
     * @param string|null $bodyType
     *
     * @return $this
     */
    public function configure($bodyType = null)
    {
        if (!in_array($bodyType, ['raw', 'text', 'html'])) {
            $bodyType = 'full';
        }

        $this->acceptHeaderValue = sprintf('application/vnd.github.%s.%s+json', $this->getApiVersion(), $bodyType);

        return $this;
    }

    /**
     * List commit comments for a repository, or list comments for a single commit when $sha is given.
     *
     * @link https://docs.github.com/rest/commits/comments#list-commit-comments-for-a-repository
     *
     * @param string      $username   the username
     * @param string      $repository the repository
     * @param string|null $sha        the SHA of the commit to list comments for
     *
     * @return array
     */
    public function all($username, $repository, $sha = null)
    {
        if (null === $sha) {
            return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/comments');
        }

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($sha).'/comments');
    }

    /**
     * Get a commit comment.
     *
     * @link https://docs.github.com/rest/commits/comments#get-a-commit-comment
     *
     * @param string     $username   the username
     * @param string     $repository the repository
     * @param int|string $comment    the ID of the comment
     *
     * @return array
     */
    public function show($username, $repository, $comment)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/comments/'.rawurlencode($comment));
    }

    /**
     * Create a commit comment.
     *
     * @link https://docs.github.com/rest/commits/comments#create-a-commit-comment
     *
     * @param string $username   the username
     * @param string $repository the repository
     * @param string $sha        the SHA of the commit to comment on
     * @param array  $params     the parameters (e.g. body, path, position, line)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, $sha, array $params)
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($sha).'/comments', $params);
    }

    /**
     * Update a commit comment.
     *
     * @link https://docs.github.com/rest/commits/comments#update-a-commit-comment
     *
     * @param string     $username   the username
     * @param string     $repository the repository
     * @param int|string $comment    the ID of the comment to update
     * @param array      $params     the parameters to update (e.g. body)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function update($username, $repository, $comment, array $params)
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/comments/'.rawurlencode($comment), $params);
    }

    /**
     * Delete a commit comment.
     *
     * @link https://docs.github.com/rest/commits/comments#delete-a-commit-comment
     *
     * @param string     $username   the username
     * @param string     $repository the repository
     * @param int|string $comment    the ID of the comment to delete
     *
     * @return array
     */
    public function remove($username, $repository, $comment)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/comments/'.rawurlencode($comment));
    }
}
