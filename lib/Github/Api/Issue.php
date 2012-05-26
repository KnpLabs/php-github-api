<?php

namespace Github\Api;

/**
 * Listing issues, searching, editing and closing your projects issues.
 *
 * @link      http://develop.github.com/p/issues.html
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class Issue extends Api
{
    /**
     * List issues by username, repo and state
     * @link http://developer.github.com/v3/issues/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $state            the issue state, can be open or closed
     * @param   array  $state             the additional parameters like milestone, assignee, lables, sort, direction
     * @return  array                     list of issues found
     */
    public function getList($username, $repo, $state = null, $parameters = array())
    {
        $url = 'repos/'.urlencode($username).'/'.urlencode($repo).'/issues';
        if ($state) {
            $parameters['state'] = $state;
        }
        if ($parameters) {
            $url .= '?'.http_build_query($parameters);
        }

        return $this->get($url);
    }

    /**
     * Search issues by username, repo, state and search term
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $state            the issue state, can be open or closed
     * @param   string  $searchTerm       the search term to filter issues by
     * @return  array                     list of issues found
     */
    public function search($username, $repo, $state, $searchTerm)
    {
        throw new \BadMethodCallException('Method cannot be implemented using new api version');
    }

    /**
     * Search issues by label
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $label            the label to filter issues by
     * @return  array                     list of issues found
     */
    public function searchLabel($username, $repo, $label)
    {
        throw new \BadMethodCallException('Method cannot be implemented using new api version');
    }

    /**
     * Get extended information about an issue by its username, repo and number
     * @link http://developer.github.com/v3/issues/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $number           the issue number
     * @return  array                     information about the issue
     */
    public function show($username, $repo, $number)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/issues/'.urlencode($number));
    }

    /**
     * Create a new issue for the given username and repo.
     * The issue is assigned to the authenticated user. Requires authentication.
     * @link http://developer.github.com/v3/issues/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $title            the new issue title
     * @param   string  $body             the new issue body
     * @return  array                     information about the issue
     */
    public function open($username, $repo, $title, $body)
    {
        return $this->post('repos/'.urlencode($username).'/'.urlencode($repo).'/issues', array(
            'title' => $title,
            'body' => $body
        ));
    }

    /**
     * Close an existing issue by username, repo and issue number. Requires authentication.
     * @link http://developer.github.com/v3/issues/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $number           the issue number
     * @return  array                     information about the issue
     */
    public function close($username, $repo, $number)
    {
        return $this->update($username, $repo, $number, array('state' => 'closed'));
    }

    /**
     * Update issue informations by username, repo and issue number. Requires authentication.
     * @link http://developer.github.com/v3/issues/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $number           the issue number
     * @param   array   $data             key=>value user attributes to update.
     *                                    key can be title or body
     * @return  array                     information about the issue
     */
    public function update($username, $repo, $number, array $data)
    {
        return $this->patch('repos/'.urlencode($username).'/'.urlencode($repo).'/issues/'.urlencode($number), $data);
    }

    /**
     * Repoen an existing issue by username, repo and issue number. Requires authentication.
     * @link http://developer.github.com/v3/issues/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $number           the issue number
     * @return  array                     informations about the issue
     */
    public function reOpen($username, $repo, $number)
    {
        return $this->update($username, $repo, $number, array('state' => 'open'));
    }

    /**
     * List an issue comments by username, repo and issue number
     * @link http://developer.github.com/v3/issues/comments/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $number           the issue number
     * @return  array                     list of issue comments
     */
    public function getComments($username, $repo, $number)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/issues/'.urlencode($number).'/comments');
    }

    /**
     * Get an issue comments by username, repo, issue number and comment id
     * @link http://developer.github.com/v3/issues/comments/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $id               the comment id
     * @return  array                     list of issue comments
     */
    public function getComment($username, $repo, $id)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/issues/comments/'.urlencode($id));
    }

    /**
     * Add a comment to the issue by username, repo and issue number
     * @link http://developer.github.com/v3/issues/comments/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $number           the issue number
     * @param   string  $body             the comment body
     * @return  array                     the created comment
     */
    public function addComment($username, $repo, $number, $body)
    {
        return $this->post('repos/'.urlencode($username).'/'.urlencode($repo).'/issues/'.urlencode($number).'/comments', array(
            'body' => $body
        ));
    }

    /**
     * List all project labels by username and repo
     * @link http://developer.github.com/v3/issues/labels/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @return  array                     list of project labels
     */
    public function getLabels($username, $repo)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/labels');
    }

    /**
     * Get project label by username and repo
     * @link http://developer.github.com/v3/issues/labels/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $name             the label name
     * @return  array                     list of project labels
     */
    public function getLabel($username, $repo, $name)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/labels/'.urlencode($name));
    }

    /**
     * Add a label to the issue by username, repo and issue number. Requires authentication.
     * @link http://developer.github.com/v3/issues/labels/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $labelName        the label name
     * @param   string  $labelColor       the label color
     * @return  array                     list of issue labels
     */
    public function addLabel($username, $repo, $labelName, $labelColor)
    {
        return $this->post('repos/'.urlencode($username).'/'.urlencode($repo).'/labels', array(
            'name' => $labelName,
            'color' => $labelColor
        ));
    }

    /**
     * Remove a label from the issue by username, repo, issue number and label name. Requires authentication.
     * @link http://developer.github.com/v3/issues/labels/
     *
     * @param   string  $username         the username
     * @param   string  $repo             the repo
     * @param   string  $labelName        the label name
     * @return  array                     list of issue labels
     */
    public function removeLabel($username, $repo, $labelName)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repo).'/labels/'.urlencode($labelName));
    }
}
