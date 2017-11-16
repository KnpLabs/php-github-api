<?php declare(strict_types=1);

namespace Github\Api\Issue;

use Github\Api\AbstractApi;
use Github\Exception\InvalidArgumentException;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/issues/labels/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Labels extends AbstractApi
{
    /**
     * Get all labels for a repository or the labels for a specific issue.
     *
     * @link https://developer.github.com/v3/issues/labels/#list-labels-on-an-issue
     * @param int|null $issue
     */
    public function all(string $username, string $repository, int $issue = null): array
    {
        if ($issue === null) {
            $path = '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels';
        } else {
            $path = '/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/labels';
        }

        return $this->get($path);
    }

    /**
     * Get a single label.
     *
     * @link https://developer.github.com/v3/issues/labels/#get-a-single-label
     */
    public function show(string $username, string $repository, string $label): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels/'.rawurlencode($label));
    }

    /**
     * Create a label for a repository.
     *
     * @link https://developer.github.com/v3/issues/labels/#create-a-label
     *
     *
     * @throws \Github\Exception\MissingArgumentException
     */
    public function create(string $username, string $repository, array $params): array
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException('name');
        }
        if (!isset($params['color'])) {
            $params['color'] = 'FFFFFF';
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels', $params);
    }

    /**
     * Delete a label for a repository.
     *
     * @link https://developer.github.com/v3/issues/labels/#remove-a-label-from-an-issue
     */
    public function deleteLabel(string $username, string $repository, string $label): array
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels/'.rawurlencode($label));
    }

    /**
     * Edit a label for a repository
     *
     * @link https://developer.github.com/v3/issues/labels/#update-a-label
     */
    public function update(string $username, string $repository, string $label, string $newName, string $color): array
    {
        $params = [
            'name'  => $newName,
            'color' => $color,
        ];

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/labels/'.rawurlencode($label), $params);
    }

    /**
     * Add a label to an issue.
     *
     * @link https://developer.github.com/v3/issues/labels/#remove-a-label-from-an-issue
     *
     * @param array|string $labels
     *
     * @thorws \Github\Exception\InvalidArgumentException
     */
    public function add(string $username, string $repository, int $issue, $labels): array
    {
        if (is_string($labels)) {
            $labels = [$labels];
        } elseif (0 === count($labels)) {
            throw new InvalidArgumentException();
        }

        return $this->post('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/labels', $labels);
    }

    /**
     * Replace labels for an issue.
     *
     * @link https://developer.github.com/v3/issues/labels/#replace-all-labels-for-an-issue
     */
    public function replace(string $username, string $repository, int $issue, array $params): array
    {
        return $this->put('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/labels', $params);
    }

    /**
     * Remove a label for an issue
     *
     * @link https://developer.github.com/v3/issues/labels/#remove-a-label-from-an-issue
     */
    public function remove(string $username, string $repository, string $issue, string $label)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/labels/'.rawurlencode($label));
    }

    /**
     * Remove all labels from an issue.
     *
     * @link https://developer.github.com/v3/issues/labels/#replace-all-labels-for-an-issue
     */
    public function clear(string $username, string $repository, string $issue)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/issues/'.rawurlencode($issue).'/labels');
    }
}
