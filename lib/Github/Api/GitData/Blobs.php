<?php

namespace Github\Api\GitData;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/git/blobs/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Blobs extends AbstractApi
{
    public function show($username, $repository, $sha, $raw = false)
    {
        if ($raw) {
            $this->client->setHeaders(array('Accept: application/vnd.github.v3.raw'));
        }

        $response = $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/git/blobs/'.urlencode($sha));

        if ($raw) {
            $this->client->clearHeaders();
        }

        return $response;
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['content'], $params['encoding'])) {
            throw new MissingArgumentException(array('content', 'encoding'));
        }

        return $this->post('repos/'.urlencode($username).'/'.urlencode($repository).'/git/blobs', $params);
    }
}
