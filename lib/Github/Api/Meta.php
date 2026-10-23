<?php

namespace Github\Api;

/**
 * Getting GitHub service information.
 *
 * @link   https://docs.github.com/rest/meta/meta
 *
 * @author Claude Dioudonnat <claude.dioudonnat@gmail.com>
 */
class Meta extends AbstractApi
{
    /**
     * Get the ip address of the hook and git servers for the GitHub.com service.
     *
     * @link https://docs.github.com/rest/meta/meta#get-github-meta-information
     *
     * @return array Information about the service of GitHub.com
     */
    public function service()
    {
        return $this->get('/meta');
    }
}
