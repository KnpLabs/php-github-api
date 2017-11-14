<?php declare(strict_types=1);

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
     */
    public function show(string $username, string $repository, string $sha, bool $recursive = false): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/trees/'.rawurlencode($sha), $recursive ? ['recursive' => 1] : []);
    }

    /**
     * Create tree for a repository.
     *
     *
     *
     * @throws \Github\Exception\MissingArgumentException
     */
    public function create(string $username, string $repository, array $params): array
    {
        if (!isset($params['tree']) || !is_array($params['tree'])) {
            throw new MissingArgumentException('tree');
        }

        if (!isset($params['tree'][0])) {
            $params['tree'] = [$params['tree']];
        }

        foreach ($params['tree'] as $key => $tree) {
            if (!isset($tree['path'], $tree['mode'], $tree['type'])) {
                throw new MissingArgumentException(["tree.$key.path", "tree.$key.mode", "tree.$key.type"]);
            }

            // If `sha` is not set, `content` is required
            if (!isset($tree['sha']) && !isset($tree['content'])) {
                throw new MissingArgumentException("tree.$key.content");
            }
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/git/trees', $params);
    }
}
