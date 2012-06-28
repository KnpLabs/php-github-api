<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class GistTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldCreateAnonymousGist()
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