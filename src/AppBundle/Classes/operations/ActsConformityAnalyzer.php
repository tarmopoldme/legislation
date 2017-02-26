<?php

namespace AppBundle\Classes\operations;
use AppBundle\Model\Act;
use AppBundle\Model\ActReferenceQuery;


/**
 *
 * @author <tarmo.poldme@brainart.ee>
 * @date 26.02.2017
 */
class ActsConformityAnalyzer
{
    /**
     * @var \AppBundle\Model\Act[]
     */
    private $acts;

    /**
     * @var array
     */
    private $matrix;

    /**
     * @var array
     */
    private $counts;

    public function __construct()
    {
        $this->matrix = [];
        $this->counts = [];
    }

    /**
     * @param $acts Act[]
     */
    public function setActs($acts)
    {
        $this->acts = $acts;
        return $this;
    }

    public function analyze()
    {
        $this
            ->buildAdjacencyMatrix()
            ->findReferenceCounts()
            ->applySeriation()
            ->calculateWeights()
        ;
    }

    /**
     * Builds two dimensional array of acts where key's present act ID's
     * @return $this
     */
    public function buildAdjacencyMatrix()
    {
        foreach ($this->acts as $act) {
            foreach ($this->acts as $act2) {
                $this->matrix[$act->getId()][$act2->getId()] = $this->hasReference($act->getId(), $act2->getId());
//                echo "Element at position: [{$act->getId()}][{$act2->getId()}]\n";
            }
        }
        return $this;
    }

    /**
     * Checks if there is relation between two passed act id's
     * Order of relation is irrelevant for conformity
     *
     * @param int $id1
     * @param int $id2
     * @return int
     */
    private function hasReference($id1, $id2)
    {
        return ActReferenceQuery::create()
            ->where('(ActReference.source_act_id=? AND ActReference.target_act_id=?)', [$id1, $id2])
            ->_or()
            ->where('(ActReference.source_act_id=? AND ActReference.target_act_id=?)', [$id2, $id1])
            ->count()
            ;
    }

    /**
     * Finds reference count of acts and orders acts by found count
     * @return $this
     */
    private function findReferenceCounts()
    {
        foreach ($this->acts as $act) {
            $count = 0;
            foreach ($this->acts as $act2) {
                if ($this->matrix[$act->getId()][$act2->getId()]) {
                    $count++;
                }
            }
            $this->counts[$act->getId()] = $count;
        }
        // sort in descending order
        arsort($this->counts);
        return $this;
    }

    /**
     * Re-create initial adjacency matrix by acts reference count
     * @return $this
     */
    private function applySeriation()
    {
        $matrix = [];
        foreach ($this->counts as $actId) {
            foreach ($this->counts as $actId2) {
                $matrix[$actId][$actId2] = $this->matrix[$actId][$actId2];
            }
        }
        $this->matrix = $matrix;
        return $this;

    }

    private function calculateWeights()
    {
        // TODO
    }

}
