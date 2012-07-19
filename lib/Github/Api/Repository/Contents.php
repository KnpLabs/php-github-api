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
    public function readme($username, $repository, $reference = null)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/contents/readme', array(
            'ref' => $reference
        ));
    }

    public function show($username, $repository, $path, $reference = null)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository).'/contents/'.urlencode($path), array(
            'ref' => $reference
        ));
    }

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
