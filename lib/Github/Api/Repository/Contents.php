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
    
    /**
     * Get the contents of a file in a repository
     *
     * @param  string  $username         the user who owns the repository
     * @param  string  $repository       the name of the repository
     * @param  string  $path             path to file
     * @param  string  $reference        reference to a branch or commit
     *
     * @return string                    content of file
     */
    public function download($username, $repository, $path, $reference = null)
    {
        $file = $this->show($username, $repository, $path, $reference);
        
        if (!isset($file['type']) || 'file' !== $file['type']) {
            throw new \Exception(sprintf('Path "%s" is not a file.', $path));
        }

        if (!isset($file['content'])) {
            throw new \Exception(sprintf('Unable to access "content" for file "%s" (possible keys: "%s").', $path, implode(', ', array_keys($file))));
        }

        if (!isset($file['encoding']) || 'base64' !== $file['encoding']) {
            throw new \Exception(sprintf('Encoding of file "%s" is not supported.', $path));
        }

        return base64_decode($file['content']);
    }
}
