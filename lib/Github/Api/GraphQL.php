<?php

namespace Github\Api;

/**
 * GraphQL API.
 *
 * @link   http://developer.github.com/v3/markdown/
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
