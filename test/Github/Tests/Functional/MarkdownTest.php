<?php

namespace Github\Tests\Functional;

/**
 * @group functional
 */
class MarkdownTest extends TestCase
{
    /**
     * @test
     */
    public function shouldRetrieveParsedMarkdownContent()
    {
        $api = $this->client->api('markdown');

        $input  = 'Hello world github/linguist#1 **cool**, and #1!';
        $output = '<p>Hello world github/linguist#1 <strong>cool</strong>, and #1!</p>';
        $html   = $api->render($input);

        $this->assertEquals($output, $html);

        $input  = 'Hello world KnpLabs/KnpBundles#1 **cool**, and #1!';
        $output = '<p>Hello world <a href="https://github.com/KnpLabs/KnpBundles/issues/1" class="issue-link" title="Display docs">KnpLabs/KnpBundles#1</a> <strong>cool</strong>, and <a href="https://github.com/KnpLabs/KnpMenu/issues/1" class="issue-link" title="Limitation when using the TwigRenderer from elsewhere than a Twig template">#1</a>!</p>';
        $html   = $api->render($input, 'gfm' , 'KnpLabs/KnpMenu');

        $this->assertEquals($output, $html);
    }
}
