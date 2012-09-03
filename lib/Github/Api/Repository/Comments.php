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
    public function all($username, $repository, $sha = null)
    {
        if (null === $sha) {
            return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/comments');
        }

        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/commits/'.urlencode($sha).'/comments');
    }

    public function show($username, $repository, $comment)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/comments/'.urlencode($comment));
    }

    public function create($username, $repository, $sha, array $params)
    {
        if (!isset($params['body'], $params['path'], $params['position'])) {
            throw new MissingArgumentException(array('body', 'path', 'position'));
        }

        return $this->post('repos/'.urlencode($username).'/'.urlencode($repository).'/commits/'.urlencode($sha).'/comments', $params);
    }

    public function update($username, $repository, $comment, array $params)
    {
        if (!isset($params['body'])) {
            throw new MissingArgumentException('body');
        }

        return $this->patch('repos/'.urlencode($username).'/'.urlencode($repository).'/comments/'.urlencode($comment), $params);
    }

    public function remove($username, $repository, $comment)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repository).'/comments/'.urlencode($comment));
    }
}
