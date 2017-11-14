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
     *
     * @param string $owner
     * @param string $repository
     *
     * @return array
     */
    public function referers(string $owner, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/popular/referrers');
    }
    /**
     * @link https://developer.github.com/v3/repos/traffic/#list-paths
     *
     * @param string $owner
     * @param string $repository
     *
     * @return array
     */
    public function paths(string $owner, string $repository): array
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/popular/paths');
    }
    /**
     * @link https://developer.github.com/v3/repos/traffic/#views
     *
     * @param string $owner
     * @param string $repository
     * @param string $per
     *
     * @return array
     */
    public function views(string $owner, string $repository, string $per = 'day'): array
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/views?per='.rawurlencode($per));
    }
    /**
     * @link https://developer.github.com/v3/repos/traffic/#clones
     *
     * @param string $owner
     * @param string $repository
     * @param string $per
     *
     * @return array
     */
    public function clones(string $owner, string $repository, string $per = 'day'): array
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/clones?per='.rawurlencode($per));
    }
}
