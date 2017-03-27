<?php

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
     *
     * @return self
     */
    public function configure($bodyType = null, $apiVersion = null)
    {
        if (!in_array($apiVersion, array('squirrel-girl-preview'))) {
            $apiVersion = $this->client->getApiVersion();
        }

        if (!in_array($bodyType, array('text', 'html', 'full'))) {
            $bodyType = 'raw';
        }

        $this->acceptHeaderValue = sprintf('application/vnd.github.%s.%s+json', $apiVersion, $bodyType);

        return $this;
    }

    public function all($username, $repository, $pullRequest = null)
    {
        if (null !== $pullRequest) {
            return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.rawurlencode($pullRequest).'/comments');
        }

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/comments');
    }

    public function show($username, $repository, $comment)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/comments/'.rawurlencode($comment));
    }

    public function create($username, $repository, $pullRequest, array $params)
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        // If `in_reply_to` is set, other options are not necessary anymore
        if (!isset($params['in_reply_to']) && !isset($params['commit_id'], $params['path'], $params['position'])) {
            throw new MissingArgumentException(array('commit_id', 'path', 'position'));
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.rawurlencode($pullRequest).'/comments', $params);
    }

    public function update($username, $repository, $comment, array $params)
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/comments/'.rawurlencode($comment), $params);
    }

    public function remove($username, $repository, $comment)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/comments/'.rawurlencode($comment));
    }
}
