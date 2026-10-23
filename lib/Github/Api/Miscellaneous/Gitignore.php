<?php

namespace Github\Api\Miscellaneous;

use Github\Api\AbstractApi;

class Gitignore extends AbstractApi
{
    /**
     * List all templates available to pass as an option when creating a repository.
     *
     * @link https://docs.github.com/rest/gitignore/gitignore#get-all-gitignore-templates
     *
     * @return array
     */
    public function all()
    {
        return $this->get('/gitignore/templates');
    }

    /**
     * Get a single template.
     *
     * @link https://docs.github.com/rest/gitignore/gitignore#get-a-gitignore-template
     *
     * @param string $template
     *
     * @return array
     */
    public function show($template)
    {
        return $this->get('/gitignore/templates/'.rawurlencode($template));
    }
}
