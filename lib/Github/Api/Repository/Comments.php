<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/repos/comments/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Comments extends AbstractApi
{
    public function configure($bodyType = null)
    {
        $apiVersion = $this->client->getOption('api_version');
        switch ($bodyType) {
            case 'raw':
                $header = sprintf('Accept: application/vnd.github.%s.raw+json', $apiVersion);
                break;

            case 'text':
                $header = sprintf('Accept: application/vnd.github.%s.text+json', $apiVersion);
                break;

            case 'html':
                $header = sprintf('Accept: application/vnd.github.%s.html+json', $apiVersion);
                break;

            default:
                $header = sprintf('Accept: application/vnd.github.%s.full+json', $apiVersion);
        }

        $this->client->setHeaders(array($header));
    }

    public function all($username, $repository, $sha = null)
    {
        if (null === $sha) {
            return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/comments');
        }

        return $this->get(
            'repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($sha).'/comments'
        );
    }

    public function show($username, $repository, $comment)
    {
        return $this->get(
            'repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/comments/'.rawurlencode($comment)
        );
    }

    public function create($username, $repository, $sha, array $params)
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->post(
            'repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($sha).'/comments',
            $params
        );
    }

    public function update($username, $repository, $comment, array $params)
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->patch(
            'repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/comments/'.rawurlencode($comment),
            $params
        );
    }

    public function remove($username, $repository, $comment)
    {
        return $this->delete(
            'repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/comments/'.rawurlencode($comment)
        );
    }
}
