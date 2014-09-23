<?php

namespace Github\HttpClient\Cache;

use Guzzle\Http\Message\Response;

class FilesystemCache implements CacheInterface
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if (false !== $content = @file_get_contents($this->getPath($id))) {
            return unserialize($content);
        }

        throw new \InvalidArgumentException(sprintf('File "%s" not found', $this->getPath($id)));
    }

    /**
     * {@inheritdoc}
     */
    public function set($id, Response $response)
    {
        if (!is_dir($this->path)) {
            @mkdir($this->path, 0777, true);
        }

        if (false === @file_put_contents($this->getPath($id), serialize($response))) {
            throw new \InvalidArgumentException(sprintf('Cannot put content in file "%s"', $this->getPath($id)));
        }
        if (false === @file_put_contents($this->getPath($id).'.etag', $response->getHeader('ETag'))) {
            throw new \InvalidArgumentException(sprintf('Cannot put content in file "%s"', $this->getPath($id).'.etag'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        return file_exists($this->getPath($id));
    }

    /**
     * {@inheritdoc}
     */
    public function getModifiedSince($id)
    {
        if ($this->has($id)) {
            return filemtime($this->getPath($id));
        }
    }

    public function getETag($id)
    {
        if (file_exists($this->getPath($id).'.etag')) {
            return file_get_contents($this->getPath($id).'.etag');
        }
    }

    /**
     * @param $id string
     *
     * @return string
     */
    protected function getPath($id)
    {
        return sprintf('%s%s%s', rtrim($this->path, DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR, md5($id));
    }
}
