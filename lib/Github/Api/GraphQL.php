<?php

namespace Github\Api;

/**
 * GraphQL API.
 *
 * Part of the Github v4 API
 *
 * @link   https://developer.github.com/v4/
 * @author Miguel Piedrafita <soy@miguelpiedrafita.com>
 */
class GraphQL extends AbstractApi
{
    /**
     * @param string $query
     *
     * @return array
     */
    public function execute($query)
    {
        $params = array(
            'query' => $query
        );

        return $this->post('/graphql', $params);
    }
}
