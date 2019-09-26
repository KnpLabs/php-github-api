<?php

namespace Github\Api\Migrations;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;
use Github\Exception\InvalidArgumentException;

/**
 * Support for Migrations
 *
 * @link   http://developer.github.com/v3/migrations
 *
 * @author Sebastian Berm <sebastian@sebsoft.nl>
 */
class SourceImport extends AbstractApi
{
    use AcceptHeaderTrait;


    /**
     * Start import of repo from other VCS
     *
     * @link https://developer.github.com/v3/migrations/source_imports/
     *
     * return array
     */
    public function start($params,$owner, $repoName)
    {
        $this->acceptHeaderValue = sprintf('application/vnd.github.barred-rock-preview');
        if (!empty($params['vcs']))
        {
           if (!in_array($params['vcs'], ['subversion','git','mercurial','tfvc']))
                throw new InvalidArgumentException('vcs');
        }
        if (empty($params['vcs_url']))
        {
                throw new MissingArgumentException('vcs_url');
        }
        return $this->put('/repos/'.rawurlencode($owner).'/'.rawurlencode($repoName).'/import', $params);
    }

    /**
     * Get the status of currently running import.
     *
     * @link https://developer.github.com/v3/migrations/source_imports/
     *
     * return array
     */
    public function status($owner, $repoName)
    {
        $this->acceptHeaderValue = sprintf('application/vnd.github.barred-rock-preview');
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repo).'/import');
    }
}
