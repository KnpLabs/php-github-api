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
    /**
     * Get the tree for a repository.
     *
     * @param string $username
     * @param string $repository
     * @param string $sha
     * @param bool   $recursive
     *
     * @return array
     */
    public function show($username, $repository, $sha, $recursive = false)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/trees/'.rawurlencode($sha), array('recursive' => $recursive ? 1 : null));
    }

    /**
     * Create tree for a repository.
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
        if (!isset($params['tree']) || !is_array($params['tree'])) {
            throw new MissingArgumentException('tree');
        }

        if (!isset($params['tree'][0])) {
            $params['tree'] = array($params['tree']);
        }

        foreach ($params['tree'] as $key => $tree) {
            if (!isset($tree['path'], $tree['mode'], $tree['type'])) {
                throw new MissingArgumentException(array("tree.$key.path", "tree.$key.mode", "tree.$key.type"));
            }

            // If `sha` is not set, `content` is required
            if (!isset($tree['sha']) && !isset($tree['content'])) {
                throw new MissingArgumentException("tree.$key.content");
            }
        }

        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/trees', $params);
    }
}
