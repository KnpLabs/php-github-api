<?php

namespace Github\Model;

use function Makasim\Values\get_object;
use function Makasim\Values\get_value;

class Fork
{
    private $values = [];

    private $objects = [];

    public function getId()
    {
        return get_value($this, 'id');
    }

    public function getNodeId()
    {
        return get_value($this, 'node_id');
    }

    public function getName()
    {
        return get_value($this, 'name');
    }

    public function getFullName()
    {
        return get_value($this, 'full_name');
    }

    public function isPrivate()
    {
        return get_value($this, 'private');
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return get_object($this, 'owner', User::class);
    }

    public function getHtmlUrl()
    {
        return get_value($this, 'html_url');
    }

    public function getDescription()
    {
        return get_value($this, 'description');
    }

    public function isFork()
    {
        return get_value($this, 'fork');
    }

    public function getUrl()
    {
        return get_value($this, 'url');
    }

    public function getForksUrl()
    {
        return get_value($this, 'forks_url');
    }

    public function getKeysUrl()
    {
        return get_value($this, 'keys_url');
    }

    public function getCollaboratorsUrl()
    {
        return get_value($this, 'collaborators_url');
    }

    public function getTeamsUrl()
    {
        return get_value($this, 'teams_url');
    }

    public function getHooksUrl()
    {
        return get_value($this, 'hooks_url');
    }

    public function getIssueEventsUrl()
    {
        return get_value($this, 'issue_events_url');
    }

    public function getEventsUrl()
    {
        return get_value($this, 'events_url');
    }

    public function getAssigneesUrl()
    {
        return get_value($this, 'assignees_url');
    }

    public function getBranchesUrl()
    {
        return get_value($this, 'branches_url');
    }

    public function getTagsUrl()
    {
        return get_value($this, 'tags_url');
    }

    public function getBlobsUrl()
    {
        return get_value($this, 'blobs_url');
    }

    public function getGitTagsUrl()
    {
        return get_value($this, 'git_tags_url');
    }

    public function getGitRefsUrl()
    {
        return get_value($this, 'git_refs_url');
    }

    public function getTreesUrl()
    {
        return get_value($this, 'trees_url');
    }

    public function getStatusesUrl()
    {
        return get_value($this, 'statuses_url');
    }

    public function getLanguagesUrl()
    {
        return get_value($this, 'languages_url');
    }

    public function getStargazersUrl()
    {
        return get_value($this, 'stargazers_url');
    }

    public function getContributorsUrl()
    {
        return get_value($this, 'contributors_url');
    }

    public function getSubscribersUrl()
    {
        return get_value($this, 'subscribers_url');
    }

    public function getSubscriptionUrl()
    {
        return get_value($this, 'subscription_url');
    }

    public function getCommitsUrl()
    {
        return get_value($this, 'commits_url');
    }

    public function getGitCommitsUrl()
    {
        return get_value($this, 'git_commits_url');
    }

    public function getCommentsUrl()
    {
        return get_value($this, 'comments_url');
    }

    public function getIssueCommentUrl()
    {
        return get_value($this, 'issue_comment_url');
    }

    public function getContentsUrl()
    {
        return get_value($this, 'contents_url');
    }

    public function getCompareUrl()
    {
        return get_value($this, 'compare_url');
    }

    public function getMergesUrl()
    {
        return get_value($this, 'merges_url');
    }

    public function getArchiveUrl()
    {
        return get_value($this, 'archive_url');
    }

    public function getDownloadsUrl()
    {
        return get_value($this, 'downloads_url');
    }

    public function getIssuesUrl()
    {
        return get_value($this, 'issues_url');
    }

    public function getPullsUrl()
    {
        return get_value($this, 'pulls_url');
    }

    public function getMilestonesUrl()
    {
        return get_value($this, 'milestones_url');
    }

    public function getNotificationsUrl()
    {
        return get_value($this, 'notifications_url');
    }

    public function getLabelsUrl()
    {
        return get_value($this, 'labels_url');
    }

    public function getReleasesUrl()
    {
        return get_value($this, 'releases_url');
    }

    public function getDeploymentsUrl()
    {
        return get_value($this, 'deployments_url');
    }

    public function getCreatedAt()
    {
        return get_value($this, 'created_at');
    }

    public function getUpdatedAt()
    {
        return get_value($this, 'updated_at');
    }

    public function getPushedAt()
    {
        return get_value($this, 'pushed_at');
    }

    public function getGitUrl()
    {
        return get_value($this, 'git_url');
    }

    public function getSshUrl()
    {
        return get_value($this, 'ssh_url');
    }

    public function getCloneUrl()
    {
        return get_value($this, 'clone_url');
    }

    public function getSvnUrl()
    {
        return get_value($this, 'svn_url');
    }

    public function getHomepage()
    {
        return get_value($this, 'homepage');
    }

    public function getSize()
    {
        return get_value($this, 'size');
    }

    public function getStargazersCount()
    {
        return get_value($this, 'stargazers_count');
    }

    public function getWatchersCount()
    {
        return get_value($this, 'watchers_count');
    }

    public function hasIssues()
    {
        return get_value($this, 'has_issues');
    }

    public function hasProjects()
    {
        return get_value($this, 'has_projects');
    }

    public function hasDownloads()
    {
        return get_value($this, 'has_downloads');
    }

    public function hasWiki()
    {
        return get_value($this, 'has_wiki');
    }

    public function hasPages()
    {
        return get_value($this, 'has_pages');
    }

    public function getForksCount()
    {
        return get_value($this, 'forks_count');
    }

    public function getMirrorUrl()
    {
        return get_value($this, 'mirror_url');
    }

    public function getArchived()
    {
        return get_value($this, 'archived');
    }

    public function getOpenIssuesCount()
    {
        return get_value($this, 'open_issues_count');
    }

    /**
     * @return License
     */
    public function getLicense()
    {
        return get_object($this, 'license', License::class);
    }

    public function getForks()
    {
        return get_value($this, 'forks');
    }

    public function getOpenIssues()
    {
        return get_value($this, 'open_issues');
    }

    public function getWatchers()
    {
        return get_value($this, 'watchers');
    }

    public function getDefaultBranch()
    {
        return get_value($this, 'default_branch');
    }

    /**
     * @return Permissions
     */
    public function getPermissions()
    {
        return get_object($this, 'permissions', Permissions::class);
    }
}
