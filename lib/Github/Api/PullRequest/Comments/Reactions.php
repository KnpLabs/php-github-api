<?php

namespace Github\Api\PullRequest\Comments;

use Github\Api\AbstractReactionsApi;

class Reactions extends AbstractReactionsApi
{
    /**
     * @param string $username
     * @param string $repository
     * @param string $id
     *
     * @return string
     */
    protected function getReactionsPath($username, $repository, $id)
    {
        return '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/comments/'.rawurlencode($id).'/reactions';
    }
}
