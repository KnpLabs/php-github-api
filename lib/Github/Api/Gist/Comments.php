<?php

namespace Github\Api\Gist;

use Github\Api\AbstractApi;

/**
 * @link   https://developer.github.com/v3/gists/comments/
 * @author Kayla Daniels <kayladnls@gmail.com>
 */
class Comments extends AbstractApi
{
    public function all($gist)
    {
        return $this->get('gists/'.rawurlencode($gist).'/comments');
    }

    public function show($gist, $comment)
    {
        return $this->get('gists/'.rawurlencode($gist).'/comments/'.rawurlencode($comment));
    }

    public function create($gist, $body)
    {
        return $this->post('gists/'.rawurlencode($gist).'/comments', array('body' => $body));
    }

    public function update($gist, $comment_id, $body)
    {
        return $this->patch('gists/'.rawurlencode($gist).'/comments/'.rawurlencode($comment_id), array('body' => $body));
    }

    public function remove($gist, $comment)
    {
        return $this->delete('gists/'.rawurlencode($gist).'/comments/'.rawurlencode($comment));
    }
}
