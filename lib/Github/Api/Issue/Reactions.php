<?php

namespace Github\Api\Issue;

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
        return '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($id).'/reactions';
    }
}
