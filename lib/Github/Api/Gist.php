<?php

namespace Github\Api;

/**
 * Creating, editing, deleting and listing gists
 *
 * @link      http://develop.github.com/p/issues.html
 * @author    Edoardo Rivello <edoardo.rivello at gmail dot com>
 * @license   MIT License
 */
class Gist extends Api
{
    /**
     * List gists by username
     * http://developer.github.com/v3/gists/
     * 
     * @param   string  $username    the username
     * @return  array                list of gist found 
     */
    public function getList($username)
    {
        return $this->get('users/'.urlencode($username).'/gists');
    }
    
    /**
     * Show a specific gist
     * http://developer.github.com/v3/gists/
     *
     * @param   string  $id          the gist id
     * @return  array                data from gist
     */
    public function getGist($id)
    {
        return $this->get('/gists/'.urlencode($id));
    }    
}