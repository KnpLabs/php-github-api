<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class GistTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldCreateGist()
    {
        $api = $this->getApiMock();
        
        $input = array(
            'description' => '',
            'public' => false,
            'files' => array(
                'filename.txt' => array(
                    'content' => 'content'
                )
            )
        );
        
        $filename = 'filename.txt';
        $content = 'content';
        
        $api->expects($this->once())
            ->method('post')
            ->with('gists', $input);
        
        $gist = $api->create($filename, $content);
    }
    
    /**
     * @test
     */
    public function shouldUpdateGist()
    {
        $api = $this->getApiMock();
        
        $input = array(
            'description' => '',
            'files' => array(
                'filename.txt' => array(
                    'filename' => 'new_name.txt',
                    'content'  => 'content'
                ),
                'filename_new.txt' => array(
                    'content'  => 'content new'
                )
            )
        );
        
        $api->expects($this->once())
            ->method('patch')
            ->with('gists/5', $input);
        
        $gist = $api->update(5, $input);
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