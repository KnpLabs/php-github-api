<?php

namespace Github\HttpClient\Cache;

use Github\HttpClient\Message\Response;

class FilesystemCache implements CacheInterface
{
    protected $path;

    public function __construct($path = null)
    {
        $this->path = $path ?: sys_get_temp_dir().DIRECTORY_SEPARATOR.'php-github-api-cache';
    }

    public function get($id)
    {
        if (false !== $content = @file_get_contents($this->getPath($id))) {
            return unserialize($content);
        }

        throw new \InvalidArgumentException(sprintf('File "%s" not found', $this->getPath($id)));
    }

    public function set($id, Response $response)
    {
        if (!is_dir($this->path)) {
            mkdir($this->path, 0777, true);
        }

        if (false === $bytes = @file_put_contents($this->getPath($id), serialize($response))) {
            throw new \InvalidArgumentException(sprintf('Cannot put content in file "%s"', $this->getPath($id)));
        }
    }

    public function getModifiedSince($id)
    {
        if (file_exists($this->getPath($id))) {
            return filemtime($this->getPath($id));
        }
    }

    protected function getPath($id)
    {
        return sprintf('%s%s%s', rtrim($this->path, DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR, md5($id));
    }
}

