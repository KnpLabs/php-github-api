<?php declare(strict_types=1);

namespace Github\Api;

/**
 * Api interface.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
interface ApiInterface
{
    public function getPerPage();

    public function setPerPage(int $perPage = null);
}
