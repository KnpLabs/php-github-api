<?php

namespace Github\Tests\Api;

use Github\Tests\ApiTestCase;

class MarkdownTest extends ApiTestCase
{
    public function testRender()
    {
        $input  = 'Hello world github/linguist#1 **cool**, and #1!';

        $api = $this->getApiMock();

        $api->expects($this->once())
            ->method('post')
            ->with('markdown', array('text' => $input, 'mode' => 'markdown'));

        $api->render($input);
    }

    protected function getApiClass()
    {
        return 'Github\Api\Markdown';
    }
}
