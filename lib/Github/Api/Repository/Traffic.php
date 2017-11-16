<?php declare(strict_types=1);

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   https://developer.github.com/v3/repos/traffic/
 * @author Miguel Piedrafita <soy@miguelpiedrafita.com>
 */
class Traffic extends AbstractApi
{
    /**
     * @link https://developer.github.com/v3/repos/traffic/#list-referrers
     */
    public function referers(string $owner, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/popular/referrers');
    }
    /**
     * @link https://developer.github.com/v3/repos/traffic/#list-paths
     */
    public function paths(string $owner, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/popular/paths');
    }
    /**
     * @link https://developer.github.com/v3/repos/traffic/#views
     */
    public function views(string $owner, string $repository, string $per = 'day'): array
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/views?per='.rawurlencode($per));
    }
    /**
     * @link https://developer.github.com/v3/repos/traffic/#clones
     */
    public function clones(string $owner, string $repository, string $per = 'day'): array
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/clones?per='.rawurlencode($per));
    }
}
