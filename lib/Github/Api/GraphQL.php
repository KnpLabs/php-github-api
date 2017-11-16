<?php declare(strict_types=1);

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
    use AcceptHeaderTrait;
    
    public function execute(string $query, array $variables = []): array
    {
        $this->acceptHeaderValue = 'application/vnd.github.v4+json';
        $params = [
            'query' => $query
        ];
        if (!empty($variables)) {
            $params['variables'] = json_encode($variables);
        }

        return $this->post('/graphql', $params);
    }
    
    public function fromFile(string $file, array $variables = []): array
    {
        return $this->execute(file_get_contents($file), $variables);
    }
}
