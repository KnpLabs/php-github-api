<?php

namespace Github\Api\GitData;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/git/references/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class References extends AbstractApi
{
    public function all($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs');
    }

    public function branches($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs/heads');
    }

    public function tags($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs/tags');
    }

    public function show($username, $repository, $reference)
    {
        $reference = $this->encodeReference($reference);

        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs/'.$reference);
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['ref'], $params['sha'])) {
            throw new MissingArgumentException(array('ref', 'sha'));
        }

        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs', $params);
    }

    public function update($username, $repository, $reference, array $params)
    {
        if (!isset($params['sha'])) {
            throw new MissingArgumentException('sha');
        }

        $reference = $this->encodeReference($reference);

        return $this->patch('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs/'.$reference, $params);
    }

    public function remove($username, $repository, $reference)
    {
        $reference = $this->encodeReference($reference);

        return $this->delete('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/refs/'.$reference);
    }

    private function encodeReference($rawReference)
    {
        return implode('/', array_map('rawurlencode', explode('/', $rawReference)));
    }
}
