<?php declare(strict_types=1);

namespace Github\Api;

use Github\Api\Gist\Comments;
use Github\Exception\MissingArgumentException;

/**
 * Creating, editing, deleting and listing gists.
 *
 * @link   http://developer.github.com/v3/gists/
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Edoardo Rivello <edoardo.rivello at gmail dot com>
 */
class Gists extends AbstractApi
{
    use AcceptHeaderTrait;

    /**
     * Configure the body type.
     *
     * @link https://developer.github.com/v3/gists/#custom-media-types
     * @param string|null $bodyType
     */
    public function configure(string $bodyType = null): self
    {
        if (!in_array($bodyType, ['base64'])) {
            $bodyType = 'raw';
        }

        $this->acceptHeaderValue = sprintf('application/vnd.github.%s.%s', $this->client->getApiVersion(), $bodyType);

        return $this;
    }

    public function all($type = null)
    {
        if (!in_array($type, ['public', 'starred'])) {
            return $this->get('/gists');
        }

        return $this->get('/gists/'.rawurlencode($type));
    }

    public function show($number)
    {
        return $this->get('/gists/'.rawurlencode($number));
    }

    public function create(array $params)
    {
        if (!isset($params['files']) || (!is_array($params['files']) || 0 === count($params['files']))) {
            throw new MissingArgumentException('files');
        }

        $params['public'] = (bool) $params['public'];

        return $this->post('/gists', $params);
    }

    public function update($id, array $params)
    {
        return $this->patch('/gists/'.rawurlencode((string) $id), $params);
    }

    public function commits($id)
    {
        return $this->get('/gists/'.rawurlencode((string) $id).'/commits');
    }

    public function fork($id)
    {
        return $this->post('/gists/'.rawurlencode((string) $id).'/fork');
    }

    public function forks($id)
    {
        return $this->get('/gists/'.rawurlencode((string) $id).'/forks');
    }

    public function remove($id)
    {
        return $this->delete('/gists/'.rawurlencode((string) $id));
    }

    public function check($id)
    {
        return $this->get('/gists/'.rawurlencode((string) $id).'/star');
    }

    public function star($id)
    {
        return $this->put('/gists/'.rawurlencode((string) $id).'/star');
    }

    public function unstar($id)
    {
        return $this->delete('/gists/'.rawurlencode((string) $id).'/star');
    }

    /**
     * Get a gist's comments.
     *
     * @link http://developer.github.com/v3/gists/comments/
     */
    public function comments(): Comments
    {
        return new Comments($this->client);
    }
}
