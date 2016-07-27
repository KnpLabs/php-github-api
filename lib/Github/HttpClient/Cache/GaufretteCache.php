<?php

namespace Github\HttpClient\Cache;

use Gaufrette\Filesystem;
use Psr\Http\Message\ResponseInterface;

/**
 * Gaufrette Cache.
 *
 * @author Massimiliano Arione <massimiliano.arione@bee-lab.net>
 */
class GaufretteCache implements CacheInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        $content = $this->filesystem->read($id);

        return ResponseSerializer::unserialize($content);
    }

    /**
     * {@inheritdoc}
     */
    public function set($id, ResponseInterface $response)
    {
        $this->filesystem->write($id, ResponseSerializer::serialize($response), true);
        $this->filesystem->write($id.'.etag', $response->getHeader('ETag'), true);
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        $this->filesystem->has($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getModifiedSince($id)
    {
        if ($this->filesystem->has($id)) {
            return $this->filesystem->mtime($id);
        }
    }

    public function getETag($id)
    {
        if ($this->filesystem->has($id)) {
            return $this->filesystem->read($id.'.etag');
        }
    }
}
