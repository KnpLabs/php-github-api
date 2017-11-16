<?php declare(strict_types=1);

namespace Github\Api\Gist;

use Github\Api\AbstractApi;
use Github\Api\AcceptHeaderTrait;

/**
 * @link   https://developer.github.com/v3/gists/comments/
 * @author Kayla Daniels <kayladnls@gmail.com>
 */
class Comments extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the body type.
     *
     * @link https://developer.github.com/v3/gists/comments/#custom-media-types
     * @param string|null $bodyType
     *
     * @return self
     */
    public function configure(string $bodyType = null): self
    {
        if (!in_array($bodyType, ['text', 'html', 'full'])) {
            $bodyType = 'raw';
        }

        $this->acceptHeaderValue = sprintf('application/vnd.github.%s.%s+json', $this->client->getApiVersion(), $bodyType);

        return $this;
    }

    /**
     * Get all comments for a gist.
     *
     * @param string $gist
     *
     * @return array
     */
    public function all(string $gist): array
    {
        return $this->get('/gists/'.rawurlencode($gist).'/comments');
    }

    /**
     * Get a comment of a gist.
     *
     * @param string $gist
     * @param int    $comment
     *
     * @return array|null
     */
    public function show(string $gist, int $comment)
    {
        return $this->get('/gists/'.rawurlencode($gist).'/comments/'.rawurlencode($comment));
    }

    /**
     * Create a comment for gist.
     *
     * @param string $gist
     * @param string $body
     *
     * @return array
     */
    public function create(string $gist, string $body): array
    {
        return $this->post('/gists/'.rawurlencode($gist).'/comments', ['body' => $body]);
    }

    /**
     * Create a comment for a gist.
     *
     * @param string $gist
     * @param int    $comment_id
     * @param string $body
     *
     * @return array|null
     */
    public function update(string $gist, int $comment_id, string $body)
    {
        return $this->patch('/gists/'.rawurlencode($gist).'/comments/'.rawurlencode($comment_id), ['body' => $body]);
    }

    /**
     * Delete a comment for a gist.
     *
     * @param string $gist
     * @param int    $comment
     *
     * @return array|null
     */
    public function remove(string $gist, int $comment)
    {
        return $this->delete('/gists/'.rawurlencode($gist).'/comments/'.rawurlencode($comment));
    }
}
