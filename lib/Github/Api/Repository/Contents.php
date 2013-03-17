<?php

namespace Github\Api\Repository;

use Github\Api\AbstractApi;
use Github\Exception\MissingArgumentException;
use Github\Exception\InvalidArgumentException;
use Github\Exception\ErrorException;

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
     * @param  string       $username    the user who owns the repository
     * @param  string       $repository  the name of the repository
     * @param  null|string  $reference   reference to a branch or commit
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
     * @param  string       $username    the user who owns the repository
     * @param  string       $repository  the name of the repository
     * @param  null|string  $path        path to file or directory
     * @param  null|string  $reference   reference to a branch or commit
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
     * @param  string       $username    the user who owns the repository
     * @param  string       $repository  the name of the repository
     * @param  string       $format      format of archive: tarball or zipball
     * @param  null|string  $reference   reference to a branch or commit
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
     * @param  string       $username    the user who owns the repository
     * @param  string       $repository  the name of the repository
     * @param  string       $path        path to file
     * @param  null|string  $reference   reference to a branch or commit
     *
     * @return null|string               content of file, or null in case of base64_decode failure
     *
     * @throws InvalidArgumentException  If $path is not a file or if its encoding is different from base64
     * @throws ErrorException            If $path doesn't include a 'content' index
     */
    public function download($username, $repository, $path, $reference = null)
    {
        $file = $this->show($username, $repository, $path, $reference);

        if (!isset($file['type']) || 'file' !== $file['type']) {
            throw new InvalidArgumentException(sprintf('Path "%s" is not a file.', $path));
        }

        if (!isset($file['content'])) {
            throw new ErrorException(sprintf('Unable to access "content" for file "%s" (possible keys: "%s").', $path, implode(', ', array_keys($file))));
        }

        if (!isset($file['encoding'])) {
            throw new InvalidArgumentException(sprintf('Can\'t decode content of file "%s", as no encoding is defined.', $path));
        }

        if ('base64' !== $file['encoding']) {
            throw new InvalidArgumentException(sprintf('Encoding "%s" of file "%s" is not supported.', $file['encoding'], $path));
        }

        return base64_decode($file['content']) ?: null;
    }
}
