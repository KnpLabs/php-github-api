<?php

namespace Github\Api;

/**
 * GraphQL API.
 *
 * Part of the Github API Early-Access Program
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
    public function execute($query)
    {
        $params = array(
            'query' => $query
        );

        return $this->post('/graphql', $params);
    }
}
