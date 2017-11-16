<?php declare(strict_types=1);

namespace Github\Api\Enterprise;

use Github\Api\AbstractApi;

class Stats extends AbstractApi
{
    /**
     * Returns the number of open and closed issues.
     *
     * @return array array with totals of open and closed issues
     */
    public function issues(): array
    {
        return $this->show('issues');
    }

    /**
     * Returns the number of active and inactive hooks.
     *
     * @return array array with totals of active and inactive hooks
     */
    public function hooks(): array
    {
        return $this->show('hooks');
    }

    /**
     * Returns the number of open and closed milestones.
     *
     * @return array array with totals of open and closed milestones
     */
    public function milestones(): array
    {
        return $this->show('milestones');
    }

    /**
     * Returns the number of organizations, teams, team members, and disabled organizations.
     *
     * @return array array with totals of organizations, teams, team members, and disabled organizations
     */
    public function orgs(): array
    {
        return $this->show('orgs');
    }

    /**
     * Returns the number of comments on issues, pull requests, commits, and gists.
     *
     * @return array array with totals of comments on issues, pull requests, commits, and gists
     */
    public function comments(): array
    {
        return $this->show('comments');
    }

    /**
     * Returns the number of GitHub Pages sites.
     *
     * @return array array with totals of GitHub Pages sites
     */
    public function pages(): array
    {
        return $this->show('pages');
    }

    /**
     * Returns the number of suspended and admin users.
     *
     * @return array array with totals of suspended and admin users
     */
    public function users(): array
    {
        return $this->show('users');
    }

    /**
     * Returns the number of private and public gists.
     *
     * @return array array with totals of private and public gists
     */
    public function gists(): array
    {
        return $this->show('gists');
    }

    /**
     * Returns the number of merged, mergeable, and unmergeable pull requests.
     *
     * @return array array with totals of merged, mergeable, and unmergeable pull requests
     */
    public function pulls(): array
    {
        return $this->show('pulls');
    }

    /**
     * Returns the number of organization-owned repositories, root repositories, forks, pushed commits, and wikis.
     *
     * @return array array with totals of organization-owned repositories, root repositories, forks, pushed commits, and wikis
     */
    public function repos(): array
    {
        return $this->show('repos');
    }

    /**
     * Returns all of the statistics.
     *
     * @return array array with all of the statistics
     */
    public function all(): array
    {
        return $this->show('all');
    }

    /**
     * @param string $type The type of statistics to show
     *
     * @return array|null
     */
    public function show(string $type)
    {
        return $this->get('/enterprise/stats/' . rawurlencode($type));
    }
}
