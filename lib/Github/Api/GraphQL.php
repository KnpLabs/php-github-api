<?php

namespace Github\Api;

/**
 * GraphQL API.
 *
 * @link   https://developer.github.com/early-access/graphql/
 * @author Miguel Piedrafita <soy@miguelpiedrafita.com>
 */
class GraphQL extends AbstractApi
{
    /**
     * @param string $query
     *
     * @return array
     */
    public function graphql($query)
    {
        $params = array(
            'query' => $query
        );

        return $this->post('/graphql', $params);
    }
}
