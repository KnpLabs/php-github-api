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
    /**
     * Configure the Accept header depending on the blob type.
     *
     * @param string|null $bodyType
     */
    public function configure($bodyType = null)
    {
        if ('raw' == $bodyType) {
            $this->client->setHeaders(array(
                'Accept' => sprintf('application/vnd.github.%s.raw', $this->client->getOption('api_version'))
            ));
        }
    }

    /**
     * Show a blob of a sha for a repository.
     *
     * @param string $username
     * @param string $repository
     * @param string $sha
     *
     * @return array
     */
    public function show($username, $repository, $sha)
    {
        $response = $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/blobs/'.rawurlencode($sha));

        return $response;
    }

    /**
     * Create a blob of a sha for a repository.
     *
     * @param string $username
     * @param string $repository
     * @param array  $params
     *
     * @return array
     *
     * @throws \Github\Exception\MissingArgumentException
     */
    public function create($username, $repository, array $params)
    {
        if (!isset($params['content'], $params['encoding'])) {
            throw new MissingArgumentException(array('content', 'encoding'));
        }

        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/blobs', $params);
    }
}
