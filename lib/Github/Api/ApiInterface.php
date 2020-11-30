<?php

namespace Github\Api;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 * @author Graham Campbell <graham@alt-three.com>
 */
interface ApiInterface
{
    /**
     * Create a new instance with the given per page parameter.
     *
     * This must be an integer between 1 and 100.
     *
     * @param int|null $perPage
     *
     * @return static
     */
    public function perPage(?int $perPage);
}
