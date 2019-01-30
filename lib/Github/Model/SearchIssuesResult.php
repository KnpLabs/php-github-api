<?php

namespace Github\Model;

use function Makasim\Values\get_objects;
use function Makasim\Values\get_value;

final class SearchIssuesResult
{
    private $values = [];

    private $objects = [];

    public function getTotalCount()
    {
        return get_value($this, 'total_count');
    }

    public function getIncompleteResults()
    {
        return get_value($this, 'incomplete_results');
    }

    /**
     * @return Issue[]
     */
    public function getItems()
    {
        return iterator_to_array(get_objects($this, 'items', Issue::class));
    }
}
