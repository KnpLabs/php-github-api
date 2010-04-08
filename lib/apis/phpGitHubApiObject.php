<?php

require_once(dirname(__FILE__).'/phpGitHubApiAbstract.php');

/**
 * Getting full versions of specific files and trees in your Git repositories.
 *
 * @author    Thibault Duplessis <thibault.duplessis at gmail dot com>
 * @license   MIT License
 */
class phpGitHubApiObject extends phpGitHubApiAbstract
{

  /**
   * Get a listing of the root tree of a project by the username, repo, and tree SHA
   * http://develop.github.com/p/object.html#trees
   *
   * @param   string $username          the username
   * @param   string $repo              the repo
   * @param   string $treeSHA           the tree sha
   * @return  array                     root tree of the project
   */
  public function showTree($username, $repo, $treeSHA)
  {
    $response = $this->api->get('tree/show/'.$username.'/'.$repo.'/'.$treeSHA);

    return $response['tree'];
  }

  /**
   * Get the data about a blob by tree SHA and file path.
   * http://develop.github.com/p/object.html#blobs
   *
   * @param   string $username          the username
   * @param   string $repo              the repo
   * @param   string $treeSHA           the tree sha
   * @param   string $path              the path
   * @return  array                     data blob of tree and path
   */
  public function showBlob($username, $repo, $treeSHA, $path)
  {
    $response = $this->api->get('blob/show/'.$username.'/'.$repo.'/'.$treeSHA .'/'.$path);

    return $response['blob'];
  }

  /**
   * Lists the data blobs of a tree by tree SHA
   * http://develop.github.com/p/object.html#blobs
   *
   * @param   string $username          the username
   * @param   string $repo              the repo
   * @param   string $treeSHA           the tree sha
   * @param   string $path              the path
   * @return  array                     data blobs of tree
   */
  public function listBlobs($username, $repo, $treeSHA)
  {
    $response = $this->api->get('blob/all/'.$username.'/'.$repo.'/'.$treeSHA);

    return $response['blobs'];
  }
}