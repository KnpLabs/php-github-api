<?php

namespace Github\Api\Project;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;
use Github\Exception\MissingArgumentException;

/**
 * "Project (classic)" cards API.
 *
 * @deprecated GitHub Projects (classic) was sunset on 2024-08-23 and this REST API is no longer part of the
 *             current documentation on docs.github.com (superseded by the Projects v2 GraphQL/REST API).
 */
class Cards extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the accept header for Early Access to the projects (classic) api.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @return $this
     */
    public function configure()
    {
        $this->acceptHeaderValue = 'application/vnd.github.inertia-preview+json';

        return $this;
    }

    /**
     * List the cards of a classic project column.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $columnId the id of the column
     * @param array      $params   the parameters (archived_state)
     *
     * @return array
     */
    public function all($columnId, array $params = [])
    {
        return $this->get('/projects/columns/'.rawurlencode($columnId).'/cards', array_merge(['page' => 1], $params));
    }

    /**
     * Get a classic project card.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $id the id of the card
     *
     * @return array
     */
    public function show($id)
    {
        return $this->get('/projects/columns/cards/'.rawurlencode($id));
    }

    /**
     * Create a classic project card.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $columnId the id of the column
     * @param array      $params   the parameters (note, or content_id/content_type)
     *
     * @return array
     */
    public function create($columnId, array $params)
    {
        return $this->post('/projects/columns/'.rawurlencode($columnId).'/cards', $params);
    }

    /**
     * Update a classic project card.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $id     the id of the card to update
     * @param array      $params the parameters to update (note, archived)
     *
     * @return array
     */
    public function update($id, array $params)
    {
        return $this->patch('/projects/columns/cards/'.rawurlencode($id), $params);
    }

    /**
     * Delete a classic project card.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $id the id of the card
     *
     * @return array
     */
    public function deleteCard($id)
    {
        return $this->delete('/projects/columns/cards/'.rawurlencode($id));
    }

    /**
     * Move a classic project card.
     *
     * @deprecated GitHub Projects (classic) was sunset by GitHub; this endpoint no longer has documentation
     *             on docs.github.com.
     *
     * @param int|string $id     the id of the card to move
     * @param array      $params the parameters (position, column_id)
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function move($id, array $params)
    {
        if (!isset($params['position'])) {
            throw new MissingArgumentException(['position']);
        }

        return $this->post('/projects/columns/cards/'.rawurlencode($id).'/moves', $params);
    }
}
