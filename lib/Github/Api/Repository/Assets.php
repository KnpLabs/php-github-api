<?php declare(strict_types=1);

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\ErrorException;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/repos/releases/
 * @author Evgeniy Guseletov <d46k16@gmail.com>
 */
class Assets extends AbstractApi
{
    /**
     * Get all release's assets in selected repository
     * GET /repos/:owner/:repo/releases/:id/assets.
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param int    $id         the id of the release
     *
     * @return array
     */
    public function all(string $username, string $repository, int $id): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/'.rawurlencode($id).'/assets');
    }

    /**
     * Get an asset in selected repository's release
     * GET /repos/:owner/:repo/releases/assets/:id.
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param int    $id         the id of the asset
     *
     * @return array
     */
    public function show(string $username, string $repository, int $id): array
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/assets/'.rawurlencode($id));
    }

    /**
     * Create an asset for selected repository's release
     * POST /repos/:owner/:repo/releases/:id/assets?name=:filename.
     *
     * Creating an asset requires support for server name indentification (SNI)
     * so this must be supported by your PHP version.
     *
     * @see http://developer.github.com/v3/repos/releases/#upload-a-release-asset
     * @see http://php.net/manual/en/openssl.constsni.php
     *
     * @param string $username    the user who owns the repo
     * @param string $repository  the name of the repo
     * @param int    $id          the id of the release
     * @param string $name        the filename for the asset
     * @param string $contentType the content type for the asset
     * @param string $content     the content of the asset
     *
     * @throws MissingArgumentException
     * @throws ErrorException
     *
     * @return array
     */
    public function create(string $username, string $repository, int $id, string $name, string $contentType, string $content): array
    {
        if (!defined('OPENSSL_TLSEXT_SERVER_NAME') || !OPENSSL_TLSEXT_SERVER_NAME) {
            throw new ErrorException('Asset upload support requires Server Name Indication. This is not supported by your PHP version. See http://php.net/manual/en/openssl.constsni.php.');
        }

        // Asset creation requires a separate endpoint, uploads.github.com.
        // Change the base url for the HTTP client temporarily while we execute
        // this request.
        $response = $this->postRaw('https://uploads.github.com/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/'.rawurlencode($id).'/assets?name='.$name, $content, ['Content-Type' => $contentType]);

        return $response;
    }

    /**
     * Edit an asset in selected repository's release
     * PATCH /repos/:owner/:repo/releases/assets/:id.
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param int    $id         the id of the asset
     * @param array  $params     request parameters
     *
     * @throws MissingArgumentException
     *
     * @return array
     */
    public function edit(string $username, string $repository, int $id, array $params): array
    {
        if (!isset($params['name'])) {
            throw new MissingArgumentException('name');
        }

        return $this->patch('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/assets/'.rawurlencode($id), $params);
    }

    /**
     * Delete an asset in selected repository's release
     * DELETE /repos/:owner/:repo/releases/assets/:id.
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param int    $id         the id of the asset
     *
     * @return array
     */
    public function remove(string $username, string $repository, int $id): array
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/releases/assets/'.rawurlencode($id));
    }
}
