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
    public function configure($bodyType = null)
    {
        if ('raw' == $bodyType) {
            $this->client->setHeaders(array(
                'Accept' => sprintf('application/vnd.github.%s.raw', $this->client->getOption('api_version'))
            ));
        }
    }

    public function show($username, $repository, $sha)
    {
        $response = $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/blobs/'.rawurlencode($sha));

        return $response;
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['content'], $params['encoding'])) {
            throw new MissingArgumentException(array('content', 'encoding'));
        }

        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/blobs', $params);
    }
}
