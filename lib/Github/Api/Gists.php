<?php

namespace Github\Api;

use Github\Api\Gist\Comments;
use Github\Exception\MissingArgumentException;

/**
 * Creating, editing, deleting and listing gists.
 *
 * @link   https://docs.github.com/rest/gists/gists
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Edoardo Rivello <edoardo.rivello at gmail dot com>
 */
class Gists extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the body type.
     *
     * @link https://docs.github.com/rest/using-the-rest-api/getting-started-with-the-rest-api
     *
     * @param string|null $bodyType
     *
     * @return $this
     */
    public function configure($bodyType = null)
    {
        if ('base64' !== $bodyType) {
            $bodyType = 'raw';
        }

        $this->acceptHeaderValue = sprintf('application/vnd.github.%s.%s', $this->getApiVersion(), $bodyType);

        return $this;
    }

    /**
     * List gists (for the authenticated user, public, or starred, depending on $type).
     *
     * @link https://docs.github.com/rest/gists/gists
     *
     * @param string|null $type
     *
     * @return array|string
     */
    public function all($type = null)
    {
        if (!in_array($type, ['public', 'starred'])) {
            return $this->get('/gists');
        }

        return $this->get('/gists/'.rawurlencode($type));
    }

    /**
     * Get a gist.
     *
     * @link https://docs.github.com/rest/gists/gists#get-a-gist
     *
     * @param string $number
     *
     * @return array
     */
    public function show($number)
    {
        return $this->get('/gists/'.rawurlencode($number));
    }

    /**
     * Get a specific revision of a gist.
     *
     * @link https://docs.github.com/rest/gists/gists#get-a-gist-revision
     *
     * @param string $number
     * @param string $sha
     *
     * @return array
     */
    public function revision($number, $sha)
    {
        return $this->get('/gists/'.rawurlencode($number).'/'.rawurlencode($sha));
    }

    /**
     * Create a gist.
     *
     * @link https://docs.github.com/rest/gists/gists#create-a-gist
     *
     * @param array $params
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function create(array $params)
    {
        if (!isset($params['files']) || (!is_array($params['files']) || 0 === count($params['files']))) {
            throw new MissingArgumentException('files');
        }

        $params['public'] = (bool) $params['public'];

        return $this->post('/gists', $params);
    }

    /**
     * Update a gist.
     *
     * @link https://docs.github.com/rest/gists/gists#update-a-gist
     *
     * @param string $id
     * @param array  $params
     *
     * @return array
     */
    public function update($id, array $params)
    {
        return $this->patch('/gists/'.rawurlencode($id), $params);
    }

    /**
     * List gist commits.
     *
     * @link https://docs.github.com/rest/gists/gists#list-gist-commits
     *
     * @param string $id
     *
     * @return array
     */
    public function commits($id)
    {
        return $this->get('/gists/'.rawurlencode($id).'/commits');
    }

    /**
     * Fork a gist.
     *
     * @link https://docs.github.com/rest/gists/gists#fork-a-gist
     *
     * @param string $id
     *
     * @return array
     */
    public function fork($id)
    {
        return $this->post('/gists/'.rawurlencode($id).'/fork');
    }

    /**
     * List gist forks.
     *
     * @link https://docs.github.com/rest/gists/gists#list-gist-forks
     *
     * @param string $id
     *
     * @return array
     */
    public function forks($id)
    {
        return $this->get('/gists/'.rawurlencode($id).'/forks');
    }

    /**
     * Delete a gist.
     *
     * @link https://docs.github.com/rest/gists/gists#delete-a-gist
     *
     * @param string $id
     *
     * @return array
     */
    public function remove($id)
    {
        return $this->delete('/gists/'.rawurlencode($id));
    }

    /**
     * Check if a gist is starred.
     *
     * @link https://docs.github.com/rest/gists/gists#check-if-a-gist-is-starred
     *
     * @param string $id
     *
     * @return array
     */
    public function check($id)
    {
        return $this->get('/gists/'.rawurlencode($id).'/star');
    }

    /**
     * Star a gist.
     *
     * @link https://docs.github.com/rest/gists/gists#star-a-gist
     *
     * @param string $id
     *
     * @return array
     */
    public function star($id)
    {
        return $this->put('/gists/'.rawurlencode($id).'/star');
    }

    /**
     * Unstar a gist.
     *
     * @link https://docs.github.com/rest/gists/gists#unstar-a-gist
     *
     * @param string $id
     *
     * @return array
     */
    public function unstar($id)
    {
        return $this->delete('/gists/'.rawurlencode($id).'/star');
    }

    /**
     * Get a gist's comments.
     *
     * @link https://docs.github.com/rest/gists/comments
     *
     * @return Comments
     */
    public function comments()
    {
        return new Comments($this->getClient());
    }
}
