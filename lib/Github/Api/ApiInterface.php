<?php

namespace Github\Api;

/**
 * Api interface.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 *
 * @deprecated since 2.18 and will removed in 3.0. Changing items per page will be done internally by the `ResultPager`.
 */
interface ApiInterface
{
    public function getPerPage();

    public function setPerPage($perPage);
}
