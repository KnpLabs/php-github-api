<?php

namespace Github\Api\Issue;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/issues/milestones/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Milestones extends AbstractApi
{
    public function all($username, $repository, array $params = array())
    {
        if (isset($params['state']) && !in_array($params['state'], array('open', 'closed'))) {
            $params['state'] = 'open';
        }
        if (isset($params['sort']) && !in_array($params['sort'], array('due_date', 'completeness'))) {
            $params['sort'] = 'due_date';
        }
        if (isset($params['direction']) && !in_array($params['direction'], array('asc', 'desc'))) {
            $params['direction'] = 'desc';
        }

        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/milestones', array_merge(array('page' => 1, 'state' => 'open', 'sort' => 'due_date', 'direction' => 'desc'), $params));
    }

    public function show($username, $repository, $id)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/milestones/'.urlencode($id));
    }

    public function create($username, $repository, array $params)
    {
        if (!isset($params['title'])) {
            throw new MissingArgumentException('title');
        }
        if (isset($params['state']) && !in_array($params['state'], array('open', 'closed'))) {
            $params['state'] = 'open';
        }

        return $this->post('repos/'.urlencode($username).'/'.urlencode($repository).'/milestones', $params);
    }

    public function update($username, $repository, $milestone, array $params)
    {
        if (isset($params['state']) && !in_array($params['state'], array('open', 'closed'))) {
            $params['state'] = 'open';
        }

        return $this->patch('repos/'.urlencode($username).'/'.urlencode($repository).'/milestones/'.urlencode($milestone), $params);
    }

    public function remove($username, $repository, $milestone)
    {
        return $this->delete('repos/'.urlencode($username).'/'.urlencode($repository).'/milestones/'.urlencode($milestone));
    }

    public function labels($username, $repository, $milestone)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/milestones/'.urlencode($milestone).'/labels');
    }
}
