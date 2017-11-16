<?php declare(strict_types=1);

namespace Github\Api\Issue;

use Github\Api\AbstractApi;

/**
 * @link   http://developer.github.com/v3/issues/events/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Events extends AbstractApi
{
    /**
     * Get all events for an issue.
     *
     * @link https://developer.github.com/v3/issues/events/#list-events-for-an-issue
     * @param int|null $issue
     */
    public function all(string $username, string $repository, int $issue = null, int $page = 1): array
    {
        if (null !== $issue) {
            $path = '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode((string) $issue).'/events';
        } else {
            $path = '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/events';
        }

        return $this->get($path, [
            'page' => $page
        ]);
    }

    /**
     * Display an event for an issue.
     *
     * @link https://developer.github.com/v3/issues/events/#get-a-single-event
     */
    public function show($username, $repository, $event): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/events/'.rawurlencode((string) $event));
    }
}
