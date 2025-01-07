<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\RuntimeException;

/**
 * @link   https://docs.github.com/en/rest/repos/custom-properties
 *
 * @author Ondřej Nyklíček <ondrej@nyoncode.cz>
 */
class CustomProperties extends AbstractApi
{
    /**
     * @param string $owner      The account owner of the repository.
     * @param string $repository The name of the repository.
     * @return array|string
     */
    public function all(string $owner, string $repository)
    {
        return $this->get('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/properties/values');
    }

    /**
     * @param string $owner        The account owner of the repository.
     * @param string $repository   The name of the repository.
     * @param string $propertyName The name of the property to retrieve.
     *
     * @throws RuntimeException if the property is not found.
     *
     * @return array
     */
    public function show(string $owner, string $repository, string $propertyName): array
    {
        $allProperties = $this->all($owner, $repository);

        if (!is_array($allProperties)) {
            throw new RuntimeException('Unexpected response from GitHub API.');
        }

        foreach ($allProperties as $property => $value) {
            if ($property === $propertyName) {
                return ['property_name' => $property, 'value' => $value];
            }
        }

        throw new RuntimeException("Property [$propertyName] not found.");
    }

    /**
     * @param string               $owner      The account owner of the repository.
     * @param string               $repository The name of the repository.
     * @param array<string, mixed> $params
     * @return array|string
     */
    public function update(string $owner, string $repository, array $params)
    {
        return $this->patch('/repos/'.rawurlencode($owner).'/'.rawurlencode($repository).'/properties/values', $params);
    }
}
