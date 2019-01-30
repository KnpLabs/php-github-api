<?php

namespace Github\Model;

use function Makasim\Values\get_value;

class Permissions
{
    private $values = [];

    public function isAdmin()
    {
        return get_value($this, 'admin');
    }

    public function isPush()
    {
        return get_value($this, 'push');
    }

    public function isPull()
    {
        return get_value($this, 'pull');
    }
}
