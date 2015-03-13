<?php

namespace Github\HttpClient\Cache;

use Guzzle\Http\Message\Response;
use Gaufrette\Filesystem;

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

        return unserialize($content);
    }

    /**
     * {@inheritdoc}
     */
    public function set($id, Response $response)
    {
        $this->filesystem->write($id, serialize($response), true);
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
