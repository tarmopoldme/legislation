<?php

namespace AppBundle\Classes\parser;

use AppBundle\Classes\api\ApiService;
use AppBundle\Classes\exception\ParserException;

/**
 *
 * @author <tarmo.poldme@brainart.ee>
 * @date 04.02.2017
 */
class ActsListingParser
{
    /**
     * @var string Url to data
     */
    private $url;

    /**
     * @var string path to tmp file to store acts listing data
     */
    private $tmpFile;

    /**
     * @var resource
     */
    private $fileHandler;

    /**
     * @var array to store parsed results
     */
    private $results = [];

    /**
     * @var ApiService
     */
    private $apiService;

    /**
     * ActsListingParser constructor.
     * @param ApiService $apiService
     * @param $url
     */
    public function __construct(ApiService $apiService, $url)
    {
        $this->apiService = $apiService;
        $this->url = $url;
        $this->tmpFile =  tempnam(sys_get_temp_dir(), 'legislation');
    }


    public function parse()
    {
        $this->init();
        $this->parseData();

        return $this;
    }

    /**
     * @throws ParserException
     */
    private function init()
    {
        // set results empty as otherwise reference my be present as this object is inited via service
        $this->results = [];
        try {
            $response = $this->apiService->callApi($this->url);
            if (false === $response) {
                throw new ParserException('Failed to get response for: ' . $this->url);
            }
            if (file_put_contents($this->tmpFile, mb_convert_encoding($response->getBody(), "UTF-8")) === false) {
                throw new ParserException(sprintf('Failed to save tmp file'));
            }
        } catch (\Exception $e) {
            throw new ParserException($e->getMessage());
        }
        $this->fileHandler = fopen($this->tmpFile, 'r');
        if (false === $this->fileHandler) {
            throw new ParserException(sprintf('Could not open input file %s for parsing', $this->tmpFile));
        }
    }

    private function parseData()
    {
        $dom = new \DOMDocument();
        $dom->loadHTMLFile($this->tmpFile);
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query("//tbody//tr");

        /** @var \DOMElement $node */
        foreach ($nodes as $node) {
            $td = $node->getElementsByTagName('td');
            /** @var \DOMElement $firstCell */
            $firstCell = $td[0];
            $secondCell = $td[1];
            /** @var \DOMElement $firstCellLink */
            $firstCellLink = $firstCell->getElementsByTagName('a');
            $url = $firstCellLink[0]->getAttribute('href');

            $this->results[] = [
                'name' => trim($firstCell->nodeValue),
                // TODO move hardcoded url prefix to config
                'url' => sprintf('https://www.riigiteataja.ee/%s', $url),
                'abbreviation' => trim($secondCell->nodeValue)
            ];
        }
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    public function __destruct()
    {
        unlink($this->tmpFile);
    }
}