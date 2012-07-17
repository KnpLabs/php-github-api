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
     * List the authenticated user’s gists or if called anonymously, 
     * this will return all public gists.
     * @link http://developer.github.com/v3/gists/
     * 
     * @return  array                list of gist found 
     */
    public function getList()
    {
        return $this->get('gists');
    }
    
    /**
     * List all public gists.
     * @link http://developer.github.com/v3/gists/
     * 
     * @return  array                list of gist found 
     */
    public function getPublicList()
    {
        return $this->get('gists/public');
    }
    
    /**
     * List the authenticated user’s starred gists. Requires authentication.
     * @link http://developer.github.com/v3/gists/
     * 
     * @return  array                list of gist found 
     */
    public function getStarredList()
    {
        return $this->get('gists/starred');
    }

    /**
     * List gists by username.
     * @link http://developer.github.com/v3/gists/
     * 
     * @param   string  $username    the username
     * @return  array                list of gist found 
     */
    public function getListByUser($username)
    {
        return $this->get('users/'.urlencode($username).'/gists');
    }
    
    /**
     * Show a specific gist.
     * @link http://developer.github.com/v3/gists/
     *
     * @param   string  $id          the gist id
     * @return  array                data from gist
     */
    public function getGist($id)
    {
        return $this->get('gists/'.urlencode($id));
    }
    
    /**
     * Create a new gist for the authenticated user otherwise for an
     * anonymous user.
     * 
     * @link http://developer.github.com/v3/gists/
     *
     * @param   array   $files            files that make up this gist
     * @param   bool    $public           1 for public, 0 for private
     * @param   string  $description      optional gist description
     * @return  array                     returns gist data
     */
    public function create($files, $public = false, $description = '')
    {
        return $this->post('gists', array(
            'description' => $description,
            'public' => $public,
            'files' => $files
        ));
    }  
    
    /**
     * Edit a gist.
     * @link http://developer.github.com/v3/gists/
     *
     * @param   string  $id              the gist id
     * @param   array   $files           files that make up this gist
     * @param   string  $description     optional gist description
     * @return  array                    informations about the gist
     */
    public function update($id, array $files = array(), $description = '')
    {
        return $this->patch('gists/'.urlencode($id), array(
            'description' => $description,
            'files' => $files
        ));
    }    
    
    /**
     * Remove a gist by id.
     * @link http://developer.github.com/v3/gists/
     * 
     * @param   int  $id          the gist id
     * @return  Response              
     */
    public function remove($id)
    {
        return $this->delete('gists/'.urlencode($id));
    }    
}
