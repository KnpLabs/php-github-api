<?php
namespace Github\Model;

use function Makasim\Values\get_value;

class PullRequest
{
    private $values = [];

    public function getHtmlUrl()
    {
        return get_value($this, 'html_url');
    }

    public function getDiffUrl()
    {
        return get_value($this, 'diff_url');
    }

    public function getPatchUrl()
    {
        return get_value($this, 'patch_url');
    }
}