<?php

namespace Github\Api\PullRequest;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;

/**
 * @link https://docs.github.com/rest/pulls/review-requests
 */
class ReviewRequest extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * @deprecated since 3.2, will be removed in 4.0.
     *
     * @return $this
     */
    public function configure()
    {
        trigger_deprecation('KnpLabs/php-github-api', '3.2', 'The "%s" is deprecated and will be removed.', __METHOD__);

        return $this;
    }

    /**
     * @link https://docs.github.com/rest/pulls/review-requests#get-all-requested-reviewers-for-a-pull-request
     *
     * @param string $username
     * @param string $repository
     * @param int    $pullRequest
     * @param array  $params
     *
     * @return array
     */
    public function all($username, $repository, $pullRequest, array $params = [])
    {
        if (!empty($params)) {
            trigger_deprecation('KnpLabs/php-github-api', '3.2', 'The "$params" parameter is deprecated, to paginate the results use the "ResultPager" instead.');
        }

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.$pullRequest.'/requested_reviewers', $params);
    }

    /**
     * @link https://docs.github.com/rest/pulls/review-requests#request-reviewers-for-a-pull-request
     *
     * @param string $username
     * @param string $repository
     * @param int    $pullRequest
     * @param array  $reviewers
     * @param array  $teamReviewers
     *
     * @return array
     */
    public function create($username, $repository, $pullRequest, array $reviewers = [], array $teamReviewers = [])
    {
        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.$pullRequest.'/requested_reviewers', ['reviewers' => $reviewers, 'team_reviewers' => $teamReviewers]);
    }

    /**
     * @link https://docs.github.com/rest/pulls/review-requests#remove-requested-reviewers-from-a-pull-request
     *
     * @param string $username
     * @param string $repository
     * @param int    $pullRequest
     * @param array  $reviewers
     * @param array  $teamReviewers
     *
     * @return array
     */
    public function remove($username, $repository, $pullRequest, array $reviewers = [], array $teamReviewers = [])
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/pulls/'.$pullRequest.'/requested_reviewers', ['reviewers' => $reviewers, 'team_reviewers' => $teamReviewers]);
    }
}
