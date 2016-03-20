<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * @link   https://developer.github.com/v3/activity/starring/#list-stargazers
 * @author Nicolas Dupont <nicolas@akeneo.com>
 */
class Stargazers extends AbstractApi
{
    /**
     * Configure the body type
     *
     * @see https://developer.github.com/v3/activity/starring/#alternative-response-with-star-creation-timestamps
     *
     * @param string $bodyType
     */
    public function configure($bodyType = null)
    {
        if ('star' === $bodyType) {
            $this->client->setHeaders(
                array(
                    'Accept' => sprintf('application/vnd.github.%s.star+json', $this->client->getOption('api_version'))
                )
            );
        }
    }

    public function all($username, $repository)
    {
        return $this->get('repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/stargazers');
    }
}
