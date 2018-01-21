<?php declare(strict_types=1);

namespace Github\Api\CurrentUser;

use Github\Api\AbstractApi;

/**
 * @link   https://developer.github.com/v3/activity/starring/
 *
 * @author Felipe Valtl de Mello <eu@felipe.im>
 */
class Starring extends AbstractApi
{
    /**
     * List repositories starred by the authenticated user.
     *
     * @link https://developer.github.com/v3/activity/starring/
     */
    public function all(int $page = 1, int $perPage = 30): array
    {
        return $this->get('/user/starred', [
            'page' => $page,
            'per_page' => $perPage,
        ]);
    }

    /**
     * Check that the authenticated user starres a repository.
     *
     * @link https://developer.github.com/v3/activity/starring/
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     *
     * @return array|null
     */
    public function check(string $username, string $repository)
    {
        return $this->get('/user/starred/'.rawurlencode($username).'/'.rawurlencode($repository));
    }

    /**
     * Make the authenticated user star a repository.
     *
     * @link https://developer.github.com/v3/activity/starring/
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     *
     * @return array|null
     */
    public function star(string $username, string $repository)
    {
        return $this->put('/user/starred/'.rawurlencode($username).'/'.rawurlencode($repository));
    }

    /**
     * Make the authenticated user unstar a repository.
     *
     * @link https://developer.github.com/v3/activity/starring
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     *
     * @return array|null
     */
    public function unstar(string $username, string $repository)
    {
        return $this->delete('/user/starred/'.rawurlencode($username).'/'.rawurlencode($repository));
    }
}
