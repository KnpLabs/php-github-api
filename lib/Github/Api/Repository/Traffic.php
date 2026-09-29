<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   https://docs.github.com/rest/metrics/traffic
 *
 * @author Miguel Piedrafita <soy@miguelpiedrafita.com>
 */
class Traffic extends AbstractApi
{
    /**
     * @link https://docs.github.com/rest/metrics/traffic#get-top-referral-sources
     *
     * @param string $owner
     * @param string $repository
     *
     * @return array
     */
    public function referers($owner, $repository)
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/popular/referrers');
    }

    /**
     * @link https://docs.github.com/rest/metrics/traffic#get-top-referral-paths
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
     * @link https://docs.github.com/rest/metrics/traffic#get-page-views
     *
     * @param string $owner
     * @param string $repository
     * @param string $per
     *
     * @return array
     */
    public function views($owner, $repository, $per = 'day')
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/views?per='.rawurlencode($per));
    }

    /**
     * @link https://docs.github.com/rest/metrics/traffic#get-repository-clones
     *
     * @param string $owner
     * @param string $repository
     * @param string $per
     *
     * @return array
     */
    public function clones($owner, $repository, $per = 'day')
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/traffic/clones?per='.rawurlencode($per));
    }
}
