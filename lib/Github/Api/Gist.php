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
        return $this->get('gists/'.urlencode($id));
    }
    
    /**
     * Create a new gist.
     * @link http://developer.github.com/v3/gists/
     *
     * @param   string  $filename         gist filename
     * @param   string  $content          gist file contents
     * @param   bool    $public           1 for public, 0 for private
     * @param   string  $description      gist description
     * @return  array                     returns gist data
     */
    public function create($filename, $content, $public = false, $description = '')
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
     * Edit a gist
     * @link http://developer.github.com/v3/gists/
     *
     * @param   string  $id              the gist id
     * @param   array   $values          the key => value pairs to post
     * @return  array                    informations about the gist
     */
    public function update($id, $values)
    {
        return $this->patch('gists/'.urlencode($id), $values);
    }    
    
    /**
     * Remove a gist by id
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
