<?php

namespace Github\Api;

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
     * Set to preview mode
     *
     * @link https://developer.github.com/v3/migrations/source_imports/
     *
     * @return self
     */
    public function configure()
    {
        $this->acceptHeaderValue = sprintf('application/vnd.github.%s.%s', 'barred-rock-preview');

        return $this;
    }

    /**
     * Start import of repo from other VCS
     *
     * @link https://developer.github.com/v3/migrations/source_imports/
     *
     * return array
     */
    public function start($params,$owner, $repoName)
    {
        if (is_null($params['vcs']))
        {
           if (!in_array($vcs, ['subversion','git','mercurial','tfvc']))
                throw new InvalidArgumentException('vcs');
        }
        if (empty($params['vcs_url']))
        {
                throw new MissingArgumentException('vcs_url');
        }

        return $this->put('/repos/'.rawurlencode($owner).'/'.rawurlencode($repo).'/import', $params);
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
            return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repo).'/import');
    }
}
