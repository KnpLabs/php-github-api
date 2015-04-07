<?php

namespace Github\Api\Issue;

use Github\Api\AbstractApi;
use Github\Exception\InvalidArgumentException;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/issues/labels/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Labels extends AbstractApi
{
    public function all($username, $repository, $issue = null)
    {
        if ($issue === null) {
            return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels');
        }

        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/labels');
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException('name');
        }
        if (!isset($params['color'])) {
            $params['color'] = 'FFFFFF';
        }

        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels', $params);
    }

    public function deleteLabel($username, $repository, $label)
    {
        return $this->delete('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels/'.rawurlencode($label));
    }

    public function update($username, $repository, $label, $newName, $color)
    {
        $params = array(
            'name' => $newName,
            'color' => $color,
        );

        return $this->patch('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels/'.rawurlencode($label), $params);
    }

    public function add($username, $repository, $issue, $labels)
    {
        if (is_string($labels)) {
            $labels = array($labels);
        } elseif (0 === count($labels)) {
            throw new InvalidArgumentException();
        }

        return $this->post('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/labels', $labels);
    }

    public function replace($username, $repository, $issue, array $params)
    {
        return $this->put('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/labels', $params);
    }

    public function remove($username, $repository, $issue, $label)
    {
        return $this->delete('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/labels/'.rawurlencode($label));
    }

    public function clear($username, $repository, $issue)
    {
        return $this->delete('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/labels');
    }
}
