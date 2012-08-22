<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;

/**
 * @link   http://developer.github.com/v3/repos/contents/
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class Contents extends AbstractApi
{
    /**
     * Get content of README file in a repository
     * @link http://developer.github.com/v3/repos/contents/
     *
     * @param  string  $username         the user who owns the repository
     * @param  string  $repository       the name of the repository
     * @param  string  $reference        reference to a branch or commit
     *
     * @return array                     information for README file
     */
    public function readme($username, $repository, $reference = null)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/readme', array(
            'ref' => $reference
        ));
    }

    /**
     * Get contents of any file or directory in a repository
     * @link http://developer.github.com/v3/repos/contents/
     *
     * @param  string  $username         the user who owns the repository
     * @param  string  $repository       the name of the repository
     * @param  string  $path             path to file or directory
     * @param  string  $reference        reference to a branch or commit
     *
     * @return array                     information for file | information for each item in directory
     */
    public function show($username, $repository, $path = null, $reference = null)
    {
        $url = 'repos/'.urlencode($username).'/'.urlencode($repository).'/contents';
        if (null !== $path) {
            $url .= '/'.urlencode($path);
        }

        return $this->get($url, array(
            'ref' => $reference
        ));
    }

    /**
     * Get content of archives in a repository
     * @link http://developer.github.com/v3/repos/contents/
     *
     * @param  string  $username         the user who owns the repository
     * @param  string  $repository       the name of the repository
     * @param  string  $format           format of archive: tarball or zipball
     * @param  string  $reference        reference to a branch or commit
     *
     * @return array                     information for archives
     */
    public function archive($username, $repository, $format, $reference = null)
    {
        if (!in_array($format, array('tarball', 'zipball'))) {
            $format = 'tarball';
        }

        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/'.urlencode($format), array(
            'ref' => $reference
        ));
    }
}
