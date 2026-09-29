<?php

namespace Github\Api\Copilot;

use Github\Api\AbstractApi;

class Usage extends AbstractApi
{
    /**
     * Get a summary of Copilot usage for an organization.
     *
     * @deprecated This endpoint has been deprecated by GitHub in favor of the Copilot usage metrics API.
     *
     * @link https://docs.github.com/rest/copilot/copilot-usage-metrics
     *
     * @param string $organization the organization name
     * @param array  $params       the parameters (e.g. since, until, per_page, page)
     *
     * @return array
     */
    public function orgUsageSummary(string $organization, array $params = []): array
    {
        return $this->get('/orgs/'.rawurlencode($organization).'/copilot/usage', $params);
    }

    /**
     * Get a summary of Copilot usage for a team within an organization.
     *
     * @deprecated This endpoint has been deprecated by GitHub in favor of the Copilot usage metrics API.
     *
     * @link https://docs.github.com/rest/copilot/copilot-usage-metrics
     *
     * @param string $organization the organization name
     * @param string $teamSlug     the slug of the team
     * @param array  $params       the parameters (e.g. since, until, per_page, page)
     *
     * @return array
     */
    public function orgTeamUsageSummary(string $organization, string $teamSlug, array $params = []): array
    {
        return $this->get(
            '/orgs/'.rawurlencode($organization).'/team/'.rawurlencode($teamSlug).'/copilot/usage',
            $params
        );
    }

    /**
     * Get a summary of Copilot usage for an enterprise.
     *
     * @deprecated This endpoint has been deprecated by GitHub in favor of the Copilot usage metrics API.
     *
     * @link https://docs.github.com/rest/copilot/copilot-usage-metrics
     *
     * @param string $enterprise the enterprise slug
     * @param array  $params     the parameters (e.g. since, until, per_page, page)
     *
     * @return array
     */
    public function enterpriseUsageSummary(string $enterprise, array $params = []): array
    {
        return $this->get('/enterprises/'.rawurlencode($enterprise).'/copilot/usage', $params);
    }

    /**
     * Get a summary of Copilot usage for a team within an enterprise.
     *
     * @deprecated This endpoint has been deprecated by GitHub in favor of the Copilot usage metrics API.
     *
     * @link https://docs.github.com/rest/copilot/copilot-usage-metrics
     *
     * @param string $enterprise the enterprise slug
     * @param string $teamSlug   the slug of the team
     * @param array  $params     the parameters (e.g. since, until, per_page, page)
     *
     * @return array
     */
    public function enterpriseTeamUsageSummary(string $enterprise, string $teamSlug, array $params = []): array
    {
        return $this->get(
            '/enterprises/'.rawurlencode($enterprise).'/team/'.rawurlencode($teamSlug).'/copilot/usage',
            $params
        );
    }
}
