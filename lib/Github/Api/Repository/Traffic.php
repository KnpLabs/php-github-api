<?php
namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

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
    public function list($owner, $repository)
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
    public function paths($owner, $repository)
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/popular/paths');
    }
    /**
     * @link https://developer.github.com/v3/repos/traffic/#views
     *
     * @param string $owner
     * @param string $repository
     *
     * @return array
     */
    public function views($owner, $repository)
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/views');
    }
    /**
     * @link https://developer.github.com/v3/repos/traffic/#clones
     *
     * @param string $owner
     * @param string $repository
     *
     * @return array
     */
    public function clones($owner, $repository)
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/clones');
    }
}
