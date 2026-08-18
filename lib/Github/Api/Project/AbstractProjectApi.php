<?php

namespace Github\Api\Project;

use Github\Api\AbstractApi;

abstract class AbstractProjectApi extends AbstractApi
{
    public function show($id, array $params = [])
    {
        return $this->get('/projects/'.rawurlencode($id), array_merge(['page' => 1], $params));
    }

    public function update($id, array $params)
    {
        return $this->patch('/projects/'.rawurlencode($id), $params);
    }

    public function deleteProject($id)
    {
        return $this->delete('/projects/'.rawurlencode($id));
    }

    public function columns()
    {
        return new Columns($this->getClient());
    }
}
