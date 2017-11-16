<?php declare(strict_types=1);

namespace Github\Api\Project;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

class Cards extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the accept header for Early Access to the projects api
     *
     * @see https://developer.github.com/v3/repos/projects/#projects
     *
     * @return self
     */
    public function configure(): self
    {
        $this->acceptHeaderValue = 'application/vnd.github.inertia-preview+json';

        return $this;
    }

    public function all($columnId, array $params = [])
    {
        return $this->get('/projects/columns/' . rawurlencode((string) $columnId) . '/cards', array_merge(['page' => 1], $params));
    }

    public function show($id)
    {
        return $this->get('/projects/columns/cards/'.rawurlencode((string) $id));
    }

    public function create($columnId, array $params)
    {
        return $this->post('/projects/columns/' . rawurlencode((string) $columnId) . '/cards', $params);
    }

    public function update($id, array $params)
    {
        return $this->patch('/projects/columns/cards/' . rawurlencode((string) $id), $params);
    }

    public function deleteCard($id)
    {
        return $this->delete('/projects/columns/cards/'.rawurlencode((string) $id));
    }

    public function move($id, array $params)
    {
        if (!isset($params['position'])) {
            throw new MissingArgumentException(['position']);
        }

        return $this->post('/projects/columns/cards/' . rawurlencode((string) $id) . '/moves', $params);
    }
}
