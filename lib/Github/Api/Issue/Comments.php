<?php

namespace Github\Api\Issue;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/issues/comments/
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
     * @link https://developer.github.com/v3/issues/comments/#custom-media-types
     *
     * @param string|null $bodyType
     *
     * @return self
     */
    public function configure($bodyType = null)
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
     *
     * @param string    $username
     * @param string    $repository
     * @param int       $issue
     * @param int|array $page       Passing integer is deprecated and will throw an exception in php-github-api version 3.0. Pass an array instead.
     *
     * @return array
     */
    public function all($username, $repository, $issue, $page = 1)
    {
        if (is_array($page)) {
            $parameters = $page;
        } else {
            @trigger_error(sprintf('Passing integer to the "page" argument in "%s" is deprecated and will throw an exception in php-github-api version 3.0. Pass an array instead.', __METHOD__), E_USER_DEPRECATED);
            $parameters = [
                'page' => $page,
            ];
        }

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.$issue.'/comments', $parameters);
    }

    /**
     * Get a comment for an issue.
     *
     * @link https://developer.github.com/v3/issues/comments/#get-a-single-comment
     *
     * @param string $username
     * @param string $repository
     * @param int    $comment
     *
     * @return array
     */
    public function show($username, $repository, $comment)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/comments/'.$comment);
    }

    /**
     * Create a comment for an issue.
     *
     * @link https://developer.github.com/v3/issues/comments/#create-a-comment
     *
     * @param string $username
     * @param string $repository
     * @param int    $issue
     * @param array  $params
     *
     * @throws \Github\Exception\MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, $issue, array $params)
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.$issue.'/comments', $params);
    }

    /**
     * Update a comment for an issue.
     *
     * @link https://developer.github.com/v3/issues/comments/#edit-a-comment
     *
     * @param string $username
     * @param string $repository
     * @param int    $comment
     * @param array  $params
     *
     * @throws \Github\Exception\MissingArgumentException
     *
     * @return array
     */
    public function update($username, $repository, $comment, array $params)
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/comments/'.$comment, $params);
    }

    /**
     * Delete a comment for an issue.
     *
     * @link https://developer.github.com/v3/issues/comments/#delete-a-comment
     *
     * @param string $username
     * @param string $repository
     * @param int    $comment
     *
     * @return array
     */
    public function remove($username, $repository, $comment)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/comments/'.$comment);
    }
}
