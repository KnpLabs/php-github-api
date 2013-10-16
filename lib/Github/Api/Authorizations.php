<?php

namespace Github\Api;

use Github\Api\AbstractApi;

/**
 * Creating, deleting and listing authorizations
 *
 * @link   http://developer.github.com/v3/oauth/
 */
class Authorizations extends AbstractApi
{
    public function all()
    {
        return $this->get('authorizations');
    }

    public function show($number)
    {
        return $this->get('authorizations/'.rawurlencode($number));
    }

    public function create(array $params)
    {
        return $this->post('authorizations', $params);
    }

    public function update($id, array $params)
    {
        return $this->patch('authorizations/'.rawurlencode($id), $params);
    }

    public function remove($id)
    {
        return $this->delete('authorizations/'.rawurlencode($id));
    }

    public function check($id, $token)
    {
        return $this->get('authorizations/'.rawurlencode($id).'/tokens/'.rawurlencode($token));
    }
}
