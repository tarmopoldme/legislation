<?php
namespace AppBundle\Classes\importer;

use AppBundle\Classes\api\ApiService;
use AppBundle\Classes\exception\InvalidResponseException;
use AppBundle\Classes\parser\ActsListingParser;
use AppBundle\Model\Act;
use AppBundle\Model\Base\ActQuery;

/**
 * @author <tarmo.poldme@brainart.ee>
 * @date 04.02.2017
 */
class ActsImporter
{
    /**
     * @var ActsListingParser
     */
    private $listingParser;

    /**
     * @var ApiService
     */
    private $apiService;

    /**
     * ActsImporter constructor.
     * @param ActsListingParser $listingParser
     * @param ApiService $apiService
     */
    public function __construct(ActsListingParser $listingParser, ApiService $apiService)
    {
        $this->listingParser = $listingParser;
        $this->apiService = $apiService;
    }

    public function purgeDatabase()
    {
        ActQuery::create()->deleteAll();
    }

    /**
     * TODO update existing acts
     * @param bool $purgeDb
     */
    public function import()
    {
        $acts = $this->parseActsListing();
        foreach ($acts as $act) {
            echo "Importing act {$act['name']}\n";
            try {
                $contentRaw = $this->getActContent($act['url']);
            } catch (InvalidResponseException $e) {
                echo $e->getMessage() . "\n";
                $contentRaw = '';
            }
            $contentClean = strip_tags($contentRaw);
            $contentClean = trim(preg_replace('!\s+!', ' ', $contentClean));

            (new Act())
                ->setName($act['name'])
                ->setUrl($act['url'])
                ->setAbbreviation($act['abbreviation'])
                ->setText($contentClean)
                ->setXml($contentRaw)
                ->save()
            ;
            sleep(2);
        }
    }

    /**
     * @return array
     */
    private function parseActsListing()
    {
        return $this->listingParser
            ->parse()
            ->getResults()
        ;
    }

    /**
     * @param $actWebUrl
     * @return mixed|string
     * @throws InvalidResponseException
     */
    private function getActContent($actWebUrl)
    {
        $xmlUrl = sprintf('%s.xml', $actWebUrl);
        $response = $this->apiService->callApi($xmlUrl);
        if (false === $response) {
            throw new InvalidResponseException(sprintf('Failed to get response for: %s', $xmlUrl));
        }
        return mb_convert_encoding($response->getBody(), "UTF-8");

    }


}
