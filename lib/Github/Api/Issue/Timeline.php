<?php

namespace Github\Api\Issue;

use Github\Api\AbstractApi;

class Timeline extends AbstractApi
{
    /**
     * Configure the accept header to use the timeline preview media type.
     *
     * @deprecated since 3.17, GitHub no longer requires a custom accept header; this method will be removed in 4.0.
     *
     * @return $this
     */
    public function configure()
    {
        trigger_deprecation('KnpLabs/php-github-api', '3.17', 'The "%s" is deprecated and will be removed.', __METHOD__);

        return $this;
    }

    /**
     * Get all events for a specific issue.
     *
     * @link https://docs.github.com/rest/issues/timeline#list-timeline-events-for-an-issue
     *
     * @param string $username
     * @param string $repository
     * @param int    $issue
     *
     * @return array
     */
    public function all($username, $repository, $issue)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.$issue.'/timeline');
    }
}
