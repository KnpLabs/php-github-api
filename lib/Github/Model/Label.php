<?php

namespace Github\Model;

use function Makasim\Values\get_value;

final class Label
{
    private $values = [];

    private $objects = [];

    public function getId()
    {
        return get_value($this, 'id');
    }

    public function getNodeId()
    {
        return get_value($this, 'node_id');
    }

    public function getUrl()
    {
        return get_value($this, 'url');
    }

    public function getName()
    {
        return get_value($this, 'name');
    }

    public function getColor()
    {
        return get_value($this, 'color');
    }
}
