<?php

namespace AppBundle\Classes\operations;

use AppBundle\Model\ActReference;
use AppBundle\Model\Base\Act;
use AppBundle\Model\Base\ActQuery;
use AppBundle\Model\Base\ActReferenceQuery;


/**
 *
 * @author <tarmo.poldme@brainart.ee>
 * @date 07.02.2017
 */
class ActsReferenceFinder
{
    /**
     * @var array of act key value pairs
     */
    private $patterns;

    public function __construct()
    {
        $this->patterns = ActQuery::create()->find()->toKeyValue('id', 'name');
    }

    public function purgeOldReferences()
    {
        ActReferenceQuery::create()->deleteAll();
    }

    public function find()
    {
        $acts = ActQuery::create()->find();
        foreach ($acts as $act) {
            echo "Finding references for act '{$act->getName()}''\n";
            $this->processActText($act);
        }
    }

    /**
     * @param Act $act
     */
    private function processActText(Act $act) {
        foreach ($this->patterns as $targetActId => $pattern) {
            if ($act->getName() === $pattern) {
                $pattern = 'käesolev seadus'; //TODO move to config
            }
            $pattern = preg_quote($pattern, '/');
            $count = preg_match_all("/$pattern/i", $act->getText());
            if ($count) {
                echo "Found {$count} references with pattern '{$pattern}' for act '{$act->getName()}'\n";
                (new ActReference())
                    ->setSourceActId($act->getId())
                    ->setTargetActId($targetActId)
                    ->setReferenceCount($count)
                    ->save()
                ;
            }
        }
    }
}