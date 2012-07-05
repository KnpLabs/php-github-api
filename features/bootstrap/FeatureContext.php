<?php

use Behat\Behat\Event\SuiteEvent,
    Behat\Behat\Event\FeatureEvent;
use Behat\Behat\Context\Step\Given,
    Behat\Behat\Context\Step\When,
Behat\Behat\Context\Step\Then;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Github\Client;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

class FeatureContext extends BehatContext
{
    private $client;
    private $lastResponse;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @AfterScenario
     */
    public function clearLastResponse()
    {
        $this->lastResponse = null;
    }

    /**
     * @When /^(?:|I )send a request for rate limit information$/
     */
    public function iSendRequestForRateLimitInformation()
    {
        $this->lastResponse = $this->client->getRateLimit();
    }

    /**
     * @Then /^(?:|I )should not reach my rate limit$/
     */
    public function iShouldNotReachMyRateLimit()
    {
        $remainingCalls = $this->client->getHttpClient()->remainingCalls;

        assertNotNull($remainingCalls);
        assertTrue(5000 > $remainingCalls);
        assertTrue(0 < $remainingCalls);
    }

    /**
     * @When /^(?:|I )send a markdown data:$/
     */
    public function iSendMarkdownData(PyStringNode $jsonString)
    {
        $data = json_decode($jsonString->getRaw(), true);

        $this->lastResponse = $this->client->getMarkdownApi()->render(
            $data['text'],
            isset($data['mode']) ? $data['mode'] : null,
            isset($data['context']) ? $data['context'] : null
        );
    }

    /**
     * @Then /^(?:the )?response should equal to html:$/
     */
    public function theResponseShouldEqualToHtml(PyStringNode $htmlString)
    {
        $expected = $htmlString->getRaw();
        $actual   = $this->lastResponse;

        assertEquals($expected, $actual, "Failed asserting that equals to \n".print_r($actual, true));
    }

    /**
     * @Then /^(?:the )?response should equal to json:$/
     */
    public function theResponseShouldEqualToJson(PyStringNode $jsonString)
    {
        $expected = json_decode($jsonString->getRaw(), true);
        $actual   = $this->lastResponse;

        if (null === $expected) {
            throw new \RuntimeException(
                "Can not convert etalon to json:\n".$jsonString->getRaw()
            );
        }

        assertEquals($expected, $actual, "Failed asserting that equals to \n".print_r($actual, true));
    }
}
