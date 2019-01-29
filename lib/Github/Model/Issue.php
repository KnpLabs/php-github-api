<?php
namespace Github\Model;

use function Makasim\Values\get_object;
use function Makasim\Values\get_objects;
use function Makasim\Values\get_value;

final class Issue
{
    private $values = [];

    private $objects = [];

    public function getUrl()
    {
        return get_value($this, 'url');
    }

    public function getRepositoryUrl()
    {
        return get_value($this, 'repository_url');
    }

    public function getLabelsUrl()
    {
        return get_value($this, 'labels_url');
    }

    public function getCommentsUrl()
    {
        return get_value($this, 'comments_url');
    }

    public function getEventsUrl()
    {
        return get_value($this, 'events_url');
    }

    public function getHtmlUrl()
    {
        return get_value($this, 'html_url');
    }

    public function getId()
    {
        return get_value($this, 'id');
    }

    public function getNodeId()
    {
        return get_value($this, 'node_id');
    }

    public function getNumber()
    {
        return get_value($this, 'number');
    }

    public function getTitle()
    {
        return get_value($this, 'title');
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return get_object($this, 'user', User::class);
    }

    /**
     * @return Label[]
     */
    public function getLabels()
    {
        return get_objects($this, 'labels', Label::class);
    }

    public function getState()
    {
        return get_value($this, 'state');
    }

    /**
     * @return User
     */
    public function getAssignee()
    {
        return get_object($this, 'assignee', User::class);
    }

    public function getMilestone()
    {
        return get_value($this, 'milestone');
    }

    public function getComments()
    {
        return get_value($this, 'comments');
    }

    public function getCreatedAt()
    {
        return get_value($this, 'created_at');
    }

    public function getUpdatedAt()
    {
        return get_value($this, 'updated_at');
    }

    public function getClosedAt()
    {
        return get_value($this, 'closed_at');
    }

    /**
     * @return PullRequest
     */
    public function getPullRequest()
    {
        return get_object($this, 'pull_request', PullRequest::class);
    }

    public function getBody()
    {
        return get_value($this, 'body');
    }

    public function getScore()
    {
        return get_value($this, 'score');
    }
}
