<?php

namespace Github\Tests\Api\Enterprise;

use Github\Tests\Api\TestCase;

class StatsTest extends TestCase
{
    /**
     * @test
     */
    public function shouldShowStats()
    {
        $expectedJson = $this->getJson();
        $expectedArray = json_encode($expectedJson);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('enterprise/stats/all')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->show('all'));
    }

    protected function getJson()
    {
        return '{"repos":{"total_repos": 212, "root_repos": 194, "fork_repos": 18, "org_repos": 51,
        "total_pushes": 3082, "total_wikis": 15 }, "hooks": { "total_hooks": 27, "active_hooks": 23,
        "inactive_hooks": 4 }, "pages": { "total_pages": 36 }, "orgs": { "total_orgs": 33, "disabled_orgs": 0,
        "total_teams": 60, "total_team_members": 314 }, "users": { "total_users": 254, "admin_users": 45,
        "suspended_users": 21 }, "pulls": { "total_pulls": 86, "merged_pulls": 60, "mergeable_pulls": 21,
        "unmergeable_pulls": 3 }, "issues": { "total_issues": 179, "open_issues": 83, "closed_issues": 96 },
        "milestones": { "total_milestones": 7, "open_milestones": 6, "closed_milestones": 1 }, "gists":
        { "total_gists": 178, "private_gists": 151, "public_gists": 25 }, "comments": { "total_commit_comments": 6,
        "total_gist_comments": 28, "total_issue_comments": 366, "total_pull_request_comments": 30 } }';
    }

    protected function getApiClass()
    {
        return 'Github\Api\Enterprise\Stats';
    }
}
