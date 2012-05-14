<?php

namespace Github\Api;

/**
 * Getting full versions of specific files and trees in your Git repositories.
 *
 * @link      http://develop.github.com/p/object.html
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class Object extends Api
{
    /**
     * Get a listing of the root tree of a project by the username, repo, and tree SHA
     * http://develop.github.com/p/object.html#trees
     *
     * @param   string $username          the username
     * @param   string $repo              the repo
     * @param   string $treeSHA           the tree sha
     * @param   boolean $resursive        the recursive flag
     * @return  array                     root tree of the project
     */
    public function showTree($username, $repo, $treeSHA, $recursive = false)
    {
        $url = 'repos/'.urlencode($username).'/'.urlencode($repo).'/git/trees/'.urlencode($treeSHA);
        if ($recursive) {
            $url .= '?recursive=1';
        }

        return $this->get($url);
    }

    /**
     * Lists the data blobs of a tree by tree SHA
     *
     * @param   string $username          the username
     * @param   string $repo              the repo
     * @param   string $treeSHA           the tree sha
     * @param   string $path              the path
     * @return  array                     data blobs of tree
     */
    public function listBlobs($username, $repo, $treeSHA)
    {
        $tree = $this->showTree($username, $repo, $treeSHA, true);

        if (isset($tree['tree'])) {
            $blobs = array_filter($tree['tree'], function ($element) {
                return 'blob' === $element['type'];
            });

            return $blobs;
        }
    }

    /**
     * Get the data about a blob by tree SHA and file path.
     *
     * @param   string $username          the username
     * @param   string $repo              the repo
     * @param   string $treeSHA           the tree sha
     * @param   string $path              the path
     * @return  array                     data blob of tree and path
     */
    public function showBlob($username, $repo, $treeSHA, $path)
    {
        $tree = $this->showTree($username, $repo, $treeSHA, true);

        if (isset($tree['tree'])) {
            $blobs = array_filter($tree['tree'], function ($element) use ($path) {
                return $path === $element['path'];
            });

            return reset($blobs);
        }
    }

    /**
     * Returns the raw text content of the object.
     *
     * @param   string $username          the username
     * @param   string $repo              the repo
     * @param   string $objectSHA         the object sha can be either a blob SHA1, a tree SHA1 or a commit SHA1
     * @return  string                    raw text content of the blob, tree or commit object
     */
    public function getRawData($username, $repo, $objectSHA)
    {
        $this->client->setHeaders(array('Accept: application/vnd.github.v3.raw'));
        $response = $this->get('repos/'.urlencode($username).'/'.urlencode($repo).'/git/blobs/'.urlencode($objectSHA));
        $this->client->clearHeaders();

        return $response;
    }
}
