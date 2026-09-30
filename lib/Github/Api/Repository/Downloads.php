<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;

/**
 * The "Downloads" API has been removed by GitHub; use the Releases API to upload and manage release assets instead.
 *
 * @deprecated This API was retired by GitHub years ago (uploading files as repository "downloads" is no longer
 *             supported) and no longer has any documentation on docs.github.com. Use the Releases API
 *             (@see \Github\Api\Repository\Releases and its Assets sub-API) to upload assets instead.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Downloads extends AbstractApi
{
    /**
     * List downloads in selected repository.
     *
     * @deprecated The GitHub Downloads API no longer exists; it was replaced by uploading assets on Releases.
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     *
     * @return array
     */
    public function all($username, $repository)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/downloads');
    }

    /**
     * Get a download in selected repository.
     *
     * @deprecated The GitHub Downloads API no longer exists; it was replaced by uploading assets on Releases.
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param int    $id         the id of the download file
     *
     * @return array
     */
    public function show($username, $repository, $id)
    {
        return $this->get('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/downloads/'.$id);
    }

    /**
     * Delete a download in selected repository.
     *
     * @deprecated The GitHub Downloads API no longer exists; it was replaced by uploading assets on Releases.
     *
     * @param string $username   the user who owns the repo
     * @param string $repository the name of the repo
     * @param int    $id         the id of the download file
     *
     * @return array
     */
    public function remove($username, $repository, $id)
    {
        return $this->delete('/repos/'.rawurlencode($username).'/'.rawurlencode($repository).'/downloads/'.$id);
    }
}
