<?php declare(strict_types=1);

namespace Github\Tests\Api\Miscellaneous;

use Github\Tests\Api\TestCase;

class MarkdownTest extends TestCase
{
    public function shouldRenderMarkdown()
    {
        $input  = 'Hello world github/linguist#1 **cool**, and #1!';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/markdown', ['text' => $input, 'mode' => 'markdown']);

        $api->render($input);
    }

    public function shouldRenderMarkdownUsingGfmMode()
    {
        $input  = 'Hello world github/linguist#1 **cool**, and #1!';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/markdown', ['text' => $input, 'mode' => 'gfm']);

        $api->render($input, 'gfm');
    }

    public function shouldSetModeToMarkdownWhenIsNotRecognized()
    {
        $input  = 'Hello world github/linguist#1 **cool**, and #1!';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/markdown', ['text' => $input, 'mode' => 'markdown']);

        $api->render($input, 'abc');
    }

    public function shouldSetContextOnlyForGfmMode()
    {
        $input  = 'Hello world github/linguist#1 **cool**, and #1!';

        $apiWithMarkdown = $this->getApiMock();
        $apiWithMarkdown->expects($this->once())
            ->method('post')
            ->with('/markdown', ['text' => $input, 'mode' => 'markdown']);

        $apiWithGfm = $this->getApiMock();
        $apiWithGfm->expects($this->once())
            ->method('post')
            ->with('/markdown', ['text' => $input, 'mode' => 'gfm', 'context' => 'someContext']);

        $apiWithMarkdown->render($input, 'markdown', 'someContext');
        $apiWithGfm->render($input, 'gfm', 'someContext');
    }

    public function shouldRenderRawFile()
    {
        $file  = 'file';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/markdown/raw', ['file' => $file]);

        $api->renderRaw($file);
    }

    protected function getApiClass(): string
    {
        return \Github\Api\Markdown::class;
    }
}
