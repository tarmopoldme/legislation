<?php
namespace AppBundle\Classes\importer;

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
     * ActsImporter constructor.
     * @param ActsListingParser $listingParser
     */
    public function __construct(ActsListingParser $listingParser)
    {
        $this->listingParser = $listingParser;
    }

    public function import()
    {
        // TODO to separate method and make optional
        ActQuery::create()->deleteAll();

        $acts = $this->parseActsListing();
        foreach ($acts as $act) {
            (new Act())
                ->setName($act['name'])
                ->setUrl($act['url'])
                ->setAbbreviation($act['abbreviation'])
                ->setText('TODO')
                ->save()
            ;
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


}
