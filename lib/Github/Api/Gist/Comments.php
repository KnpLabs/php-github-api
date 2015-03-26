<?php

namespace Github\Api\Gist;

use Github\Api\AbstractApi;

/**
 *
 * @link   https://developer.github.com/v3/gists/comments/
 * @author Kayla Daniels <kayladnls@gmail.com>
 * @author Edoardo Rivello <edoardo.rivello at gmail dot com>
 */
class Comments extends AbstractApi
{
    // GET /gists/:gist_id/comments
    public function all($gist)
    {
        return $this->get('gists/'.rawurlencode($gist)."/comments");
    }

    //GET /gists/:gist_id/comments/:id
    public function show($gist, $comment)
    {
        return $this->get('gists/'.rawurlencode($gist).'/comments/'.rawurlencode($comment));
    }

    //POST /gists/:gist_id/comments
    public function create($gist, $body)
    {
        return $this->post('gists/'.rawurlencode($gist)."/comments", array($body));
    }

    //PATCH /gists/:gist_id/comments/:id
    public function update($gist, $comment_id, $body)
    {
        return $this->patch('gists/'.rawurlencode($gist)."/comments/".rawurlencode($comment_id), array($body));
    }

    //DELETE /gists/:gist_id/comments/:id
    public function remove($gist, $comment)
    {
        return $this->delete('gists/'.rawurlencode($gist)."/comments/".rawurlencode($comment));
    }
}
