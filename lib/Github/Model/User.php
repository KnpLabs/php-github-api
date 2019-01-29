<?php
namespace Github\Model;

use function Makasim\Values\get_value;

class User
{
    private $values = [];

    public function getLogin()
    {
        return get_value($this, 'login');
    }

    public function getId()
    {
        return get_value($this, 'id');
    }

    public function getNodeId()
    {
        return get_value($this, 'node_id');
    }

    public function getAvatarUrl()
    {
        return get_value($this, 'avatar_url');
    }

    public function getGravatarUrl()
    {
        return get_value($this, 'gravatar_id');
    }

    public function getUrl()
    {
        return get_value($this, 'url');
    }

    public function getHtmlUrl()
    {
        return get_value($this, 'html_url');
    }

    public function getFollowersUrl()
    {
        return get_value($this, 'followers_url');
    }

    public function getFollowingUrl()
    {
        return get_value($this, 'following_url');
    }

    public function getGistsUrl()
    {
        return get_value($this, 'gists_url');
    }

    public function getStarredUrl()
    {
        return get_value($this, 'starred_url');
    }

    public function getSubscriptionsUrl()
    {
        return get_value($this, 'subscriptions_url');
    }

    public function getOrganizationsUrl()
    {
        return get_value($this, 'organizations_url');
    }

    public function getReposUrl()
    {
        return get_value($this, 'repos_url');
    }

    public function getEventsUrl()
    {
        return get_value($this, 'events_url');
    }

    public function getReceivedEventsUrl()
    {
        return get_value($this, 'received_events_url');
    }

    public function getType()
    {
        return get_value($this, 'type');
    }

    public function isSiteAdmin()
    {
        return get_value($this, 'site_admin');
    }
}