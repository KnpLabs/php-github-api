<?php

namespace Github\Api\GitData;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/git/trees/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Trees extends AbstractApi
{
    public function show($username, $repository, $sha, $recursive = false)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/git/trees/'.urlencode($sha), array('recursive' => $recursive ? 1 : null));
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['tree'])) {
            throw new MissingArgumentException('tree');
        }
        if (!isset($params['tree']['path'], $params['tree']['mode'], $params['tree']['type'])) {
            throw new MissingArgumentException(array('tree.path', 'tree.mode', 'tree.type'));
        }

        // If `sha` is not set, `content` is required
        if (!isset($params['tree']['sha']) && !isset($params['tree']['content'])) {
            throw new MissingArgumentException('tree.content');
        }

        return $this->post('repos/'.urlencode($username).'/'.urlencode($repository).'/git/trees', $params);
    }
}
