<?php
namespace Github\Model;

use function Makasim\Values\get_value;

final class License
{
    private $values = [];

    public function getKey()
    {
        return get_value($this, 'key');
    }

    public function getName()
    {
        return get_value($this, 'name');
    }

    public function getSpdxId()
    {
        return get_value($this, 'spdx_id');
    }

    public function getUrl()
    {
        return get_value($this, 'url');
    }

    public function getNodeId()
    {
        return get_value($this, 'node_id');
    }
}
