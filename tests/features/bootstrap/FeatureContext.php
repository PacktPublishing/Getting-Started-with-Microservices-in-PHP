<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $baseUrl = "http://localhost:808";
    private $client            = null;
    private $restObject        = null;
    private $response          = null;
    private $requestUrl        = null;


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->restObject = new stdClass();

    }

    /**
     * @When /^I issue a "([^"]*)" request to "([^"]*)"$/
     */
    public function iIssueARequestTo($verb, $page)
    {
        $this->requestUrl = $this->baseUrl.$page;
        $resp = null;

        switch (strtolower($verb)) {
            case 'get':
                $resp = $this->client->request('GET', $this->requestUrl);
                break;
            case 'delete':
                try {
                    $resp = $this->client->request('DELETE', $this->requestUrl);
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    $resp = $e->getResponse();
                }
                break;
            case 'put':
                try {
                    $resp = $this->client->request('PUT', $this->requestUrl);
                } catch (\GuzzleHttp\Exception\RequestException$e) {
                    $resp = $e->getResponse();
                }
                break;
        }
        $this->response = $resp;


        //throw new PendingException();
    }

    /**
     * @Then The Response Code will be :arg1
     */
    public function theResponseCodeWillBe($code)
    {
        //print_r(json_decode($this->response->getBody(), true));
        $testCode = $this->response->getStatusCode();
        if ($code != $testCode) {
            throw new Exception("Invliad Response Code.  Expected: $code got: $testCode");
        }

        //throw new PendingException();
    }

    /**
     * @Then The Response Will be JSON
     */
    public function theResponseWillBeJson()
    {
        $json = json_decode($this->response->getBody(), true);
        if ($json === false || $json == null) {
            throw new Exception("Return is not valid JSON");
        }
    }
}
