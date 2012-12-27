<?php

namespace Github\Tests\Api;

class MarkdownTest extends TestCase
{
    /**
     * @test
     */
    public function shouldRenderMarkdown()
    {
        $input  = 'Hello world github/linguist#1 **cool**, and #1!';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('markdown', array('text' => $input, 'mode' => 'markdown'));

        $api->render($input);
    }

    /**
     * @test
     */
    public function shouldRenderMarkdownUsingGfmMode()
    {
        $input  = 'Hello world github/linguist#1 **cool**, and #1!';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('markdown', array('text' => $input, 'mode' => 'gfm'));

        $api->render($input, 'gfm');
    }

    /**
     * @test
     */
    public function shouldSetModeToMarkdownWhenIsNotRecognized()
    {
        $input  = 'Hello world github/linguist#1 **cool**, and #1!';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('markdown', array('text' => $input, 'mode' => 'markdown'));

        $api->render($input, 'abc');
    }

    /**
     * @test
     */
    public function shouldSetContextOnlyForGfmMode()
    {
        $input  = 'Hello world github/linguist#1 **cool**, and #1!';

        $apiWithMarkdown = $this->getApiMock();
        $apiWithMarkdown->expects($this->once())
            ->method('post')
            ->with('markdown', array('text' => $input, 'mode' => 'markdown'));

        $apiWithGfm = $this->getApiMock();
        $apiWithGfm->expects($this->once())
            ->method('post')
            ->with('markdown', array('text' => $input, 'mode' => 'gfm', 'context' => 'someContext'));

        $apiWithMarkdown->render($input, 'markdown', 'someContext');
        $apiWithGfm->render($input, 'gfm', 'someContext');
    }

    /**
     * @test
     */
    public function shouldRenderRawFile()
    {
        $file  = 'file';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('markdown/raw', array('file' => $file));

        $api->renderRaw($file);
    }

    protected function getApiClass()
    {
        return 'Github\Api\Markdown';
    }
}
