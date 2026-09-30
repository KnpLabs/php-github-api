<?php

namespace Github\Api\Issue;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;

class Timeline extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the accept header to use the timeline preview media type.
     *
     * @return $this
     */
    public function configure()
    {
        $this->acceptHeaderValue = 'application/vnd.github.mockingbird-preview';

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
