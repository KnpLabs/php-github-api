<?php

namespace Github\Api\Issue;

use Github\Api\AbstractApi;
use Github\Exception\InvalidArgumentException;

/**
 * @link   http://developer.github.com/v3/issues/labels/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Labels extends AbstractApi
{
    public function all($username, $repository, $issue)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/issues/'.urlencode($issue).'/labels');
    }

    public function add($username, $repository, $issue, $labels)
    {
        if (is_string($labels)) {
            $labels = array($labels);
        } elseif (0 === count($labels)) {
            throw new InvalidArgumentException();
        }

        return $this->post('repos/'.urlencode($username).'/'.urlencode($repository).'/issues/'.urlencode($issue).'/labels', $labels);
    }

    public function replace($username, $repository, $issue, array $params)
    {
        return $this->put('repos/'.urlencode($username).'/'.urlencode($repository).'/issues/'.urlencode($issue).'/labels', $params);
    }

    public function remove($username, $repository, $issue, $label)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repository).'/issues/'.urlencode($issue).'/labels/'.urlencode($label));
    }

    public function clear($username, $repository, $issue)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repository).'/issues/'.urlencode($issue).'/labels');
    }
}
