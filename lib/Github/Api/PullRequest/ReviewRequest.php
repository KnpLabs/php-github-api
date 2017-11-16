<?php declare(strict_types=1);

namespace Github\Api\PullRequest;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;

/**
 * @link https://developer.github.com/v3/pulls/review_requests/
 */
class ReviewRequest extends AbstractApi
{
    use AcceptHeaderTrait;

    public function configure()
    {
        return $this;
    }

    /**
     * @link https://developer.github.com/v3/pulls/review_requests/#list-review-requests
     */
    public function all(string $username, string $repository, int $pullRequest, array $params = []): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.$pullRequest.'/requested_reviewers', $params);
    }

    /**
     * @link https://developer.github.com/v3/pulls/review_requests/#create-a-review-request
     */
    public function create(string $username, string $repository, int $pullRequest, array $reviewers): string
    {
        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.$pullRequest.'/requested_reviewers', ['reviewers' => $reviewers]);
    }

    /**
     * @link https://developer.github.com/v3/pulls/review_requests/#delete-a-review-request
     */
    public function remove(string $username, string $repository, int $pullRequest, array $reviewers): string
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.$pullRequest.'/requested_reviewers', ['reviewers' => $reviewers]);
    }
}
