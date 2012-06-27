<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class GistTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldBuildValidQueryForStarredList()
    {
        $api = $this->getApiMock();
        
        $api->expects($this->once())
            ->method('get')
            ->with('gists/starred');
        
        $gists = $api->getStarredList();
    }
    
    /**
     * @test
     */
    public function shouldCreateAnonymousGist()
    {
        $api = $this->getApiMock();
        
        $files = array(
            'filename.txt' => array(
                'content' => 'content'
            )
        );
        
        $input = array(
            'description' => '',
            'public' => false,
            'files' => $files
        );
        
        $api->expects($this->once())
            ->method('post')
            ->with('gists', $input);
        
        $gist = $api->create($files);
    }
    
    /**
     * @test
     */
    public function shouldUpdateGist()
    {
        $api = $this->getApiMock();
        
        $files =  array(
            'filename.txt' => array(
                'filename' => 'new_name.txt',
                'content'  => 'content'
            ),
            'filename_new.txt' => array(
                'content'  => 'content new'
            )
        );
        
        $input = array(
            'description' => 'jimbo',
            'files' => $files
        );
        
        $api->expects($this->once())
            ->method('patch')
            ->with('gists/5', $input);
        
        $gist = $api->update(5, $files, 'jimbo');
    }    
    
    /**
     * @test
     */
    public function shouldDeleteGist()
    {
        $api = $this->getApiMock();
                
        $api->expects($this->once())
            ->method('delete')
            ->with('gists/5');
        
        $api->remove(5);
    }    
    
    protected function getApiClass()
    {
        return 'Github\Api\Gist';
    }    
}
