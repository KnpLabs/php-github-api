<?php

namespace Github\Api;

use Github\Exception\MissingArgumentException;
use Github\Api\Gist\Comments;

/**
 * Creating, editing, deleting and listing gists.
 *
 * @link   http://developer.github.com/v3/gists/
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Edoardo Rivello <edoardo.rivello at gmail dot com>
 */
class Gists extends AbstractApi
{
    public function all($type = null)
    {
        if (!in_array($type, array('public', 'starred'))) {
            return $this->get('gists');
        }

        return $this->get('gists/'.rawurlencode($type));
    }

    public function show($number)
    {
        return $this->get('gists/'.rawurlencode($number));
    }

    public function create(array $params)
    {
        if (!isset($params['files']) || (!is_array($params['files']) || 0 === count($params['files']))) {
            throw new MissingArgumentException('files');
        }

        $params['public'] = (bool) $params['public'];

        return $this->post('gists', $params);
    }

    public function update($id, array $params)
    {
        return $this->patch('gists/'.rawurlencode($id), $params);
    }

    public function commits($id)
    {
        return $this->get('gists/'.rawurlencode($id).'/commits');
    }

    public function fork($id)
    {
        return $this->post('gists/'.rawurlencode($id).'/fork');
    }

    public function forks($id)
    {
        return $this->get('gists/'.rawurlencode($id).'/forks');
    }

    public function remove($id)
    {
        return $this->delete('gists/'.rawurlencode($id));
    }

    public function check($id)
    {
        return $this->get('gists/'.rawurlencode($id).'/star');
    }

    public function star($id)
    {
        return $this->put('gists/'.rawurlencode($id).'/star');
    }

    public function unstar($id)
    {
        return $this->delete('gists/'.rawurlencode($id).'/star');
    }

    /**
     * Get a gist's comments.
     *
     * @link http://developer.github.com/v3/gists/comments/
     *
     * @return Comments
     */
    public function comments()
    {
        return new Comments($this->client);
    }
}
