<?php

namespace Github\Api;

/**
 * Creating, editing, deleting and listing gists
 *
 * @link      http://developer.github.com/v3/gists/
 * @author    Edoardo Rivello <edoardo.rivello at gmail dot com>
 * @license   MIT License
 */
class Gist extends Api
{
    /**
     * List gists by username
     * @link http://developer.github.com/v3/gists/
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
     * @link http://developer.github.com/v3/gists/
     *
     * @param   string  $id          the gist id
     * @return  array                data from gist
     */
    public function getGist($id)
    {
        return $this->get('/gists/'.urlencode($id));
    }
    
    /**
     * Create a new gist.
     * The gist is assigned to null user.
     * @link http://developer.github.com/v3/issues/
     *
     * @param   string  $description      gist description
     * @param   bool    $public           1 for public, 0 for private
     * @param   string  $filename         gist filename
     * @param   string  $content          gist file contents
     * @return  array                     information about the gist
     */
    public function create($filename, $content, $description = '', $public = false)
    {
        $input = array(
            'description' => $description,
            'public' => $public,
            'files' => array(
                $filename => array(
                    'content' => $content
                )
            )
        );
        
        return $this->post('gists', $input);
    }    
    
    /**
     * Remove a gist by id
     * Requires authentication.
     * @link http://developer.github.com/v3/issues/
     * 
     * @param   int  $id          the gist id
     * @return  null              
     */
    public function remove($id)
    {
        return $this->delete('gists/'.urlencode($id));
    }    
}