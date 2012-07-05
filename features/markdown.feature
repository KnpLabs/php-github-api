Feature: Markdown rendering
  In order to get rendered markdown file
  As an anonymous user
  I need to be able to post data to /markdown resource

  Scenario: Get rendered markdown file
    When I send a markdown data:
    """
    {
      "text": "Hello world github/linguist#1 **cool**, and #1!"
    }
    """
    Then the response should equal to html:
    """
    <p>Hello world github/linguist#1 <strong>cool</strong>, and #1!</p>
    """

  Scenario: Get rendered markdown file with context
    When I send a markdown data:
    """
    {
      "text": "Hello world KnpLabs/KnpBundles#1 **cool**, and #1!",
      "mode": "gfm",
      "context": "KnpLabs/KnpMenu"
    }
    """
    Then the response should equal to html:
    """
    <p>Hello world <a href="https://github.com/KnpLabs/KnpBundles/issues/1" class="issue-link" title="Display docs">KnpLabs/KnpBundles#1</a> <strong>cool</strong>, and <a href="https://github.com/KnpLabs/KnpMenu/issues/1" class="issue-link" title="Limitation when using the TwigRenderer from elsewhere than a Twig template">#1</a>!</p>
    """
