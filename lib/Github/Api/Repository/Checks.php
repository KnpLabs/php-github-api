<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

/**
 * @link https://developer.github.com/v3/checks/
 * @deprecated since 2.17 and will be removed in 3.0. Use the "Github\Api\Repository\Checks\CheckRuns" or "Github\Api\Repository\Checks\CheckSuits" api classes instead.
 *
 * @author Zack Galbreath <zack.galbreath@kitware.com>
 */
class Checks extends AbstractApi
{
    // NEXT_MAJOR: remove trait use.
    use AcceptHeaderTrait;

    /**
     * @link https://developer.github.com/v3/checks/runs/#create-a-check-run
     *
     * @param string $username
     * @param string $repository
     * @param array  $params
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create($username, $repository, array $params = [])
    {
        @trigger_error(sprintf('The "%s" method is deprecated since knp-labs/php-github-api 2.17 and will be removed in knp-labs/php-github-api 3.0. Use the "Github\Api\Repository\Checks\CheckRuns::create" method instead.', __METHOD__), E_USER_DEPRECATED);

        if (!isset($params['name'], $params['head_sha'])) {
            throw new MissingArgumentException(['name', 'head_sha']);
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs', $params);
    }

    /**
     * @link https://developer.github.com/v3/checks/runs/#update-a-check-run
     *
     * @param string $username
     * @param string $repository
     * @param string $checkRunId
     * @param array  $params
     *
     * @return array
     */
    public function update($username, $repository, $checkRunId, array $params = [])
    {
        @trigger_error(sprintf('The "%s" method is deprecated since knp-labs/php-github-api 2.17 and will be removed in knp-labs/php-github-api 3.0. Use the "Github\Api\Repository\Checks\CheckRuns::update" method instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs/'.rawurlencode($checkRunId), $params);
    }

    /**
     * @link https://developer.github.com/v3/checks/runs/#list-check-runs-for-a-git-reference
     *
     * @param string $username
     * @param string $repository
     * @param string $ref
     * @param array  $params
     *
     * @return array
     */
    public function all($username, $repository, $ref, $params = [])
    {
        @trigger_error(sprintf('The "%s" method is deprecated since knp-labs/php-github-api 2.17 and will be removed in knp-labs/php-github-api 3.0. Use the "Github\Api\Repository\Checks\CheckRuns::allForReference" method instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/commits/'.rawurlencode($ref).'/check-runs', $params);
    }

    /**
     * @link https://developer.github.com/v3/checks/runs/#get-a-check-run
     *
     * @param string $username
     * @param string $repository
     * @param string $checkRunId
     *
     * @return array
     */
    public function show($username, $repository, $checkRunId)
    {
        @trigger_error(sprintf('The "%s" method is deprecated since knp-labs/php-github-api 2.17 and will be removed in knp-labs/php-github-api 3.0. Use the "Github\Api\Repository\Checks\CheckRuns::show" method instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs/'.rawurlencode($checkRunId));
    }

    /**
     * @link https://developer.github.com/v3/checks/runs/#list-check-run-annotations
     *
     * @param string $username
     * @param string $repository
     * @param string $checkRunId
     *
     * @return array
     */
    public function annotations($username, $repository, $checkRunId)
    {
        @trigger_error(sprintf('The "%s" method is deprecated since knp-labs/php-github-api 2.17 and will be removed in knp-labs/php-github-api 3.0. Use the "Github\Api\Repository\Checks\CheckRuns::annotations" method instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/check-runs/'.rawurlencode($checkRunId).'/annotations');
    }
}
