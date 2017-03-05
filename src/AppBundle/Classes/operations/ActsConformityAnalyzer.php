<?php

namespace AppBundle\Classes\operations;
use AppBundle\Model\Act;
use AppBundle\Model\ActReferenceQuery;
use AppBundle\Model\Base\ActQuery;
use Symfony\Component\Console\Output\OutputInterface;


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

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * ActsConformityAnalyzer constructor.
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
        $this->matrix = [];
        $this->counts = [];
    }

    /**
     * @param $acts Act[]
     * @return $this
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
        $this->output->writeln('Building adjacency matrix');
        foreach ($this->acts as $act) {
            $this->output->writeln('Building columns for act: ' . $act->getId());
            foreach ($this->acts as $act2) {
                $this->matrix[$act->getId()][$act2->getId()] = $this->hasReference($act->getId(), $act2->getId());
            }
        }
        return $this;
    }

    /**
     * Checks if there is relation between two passed act id's
     * Order of relation is irrelevant for conformity as symmetric adjacency matrix is used for calculation
     *
     * @param int $id1
     * @param int $id2
     * @return boolean
     */
    private function hasReference($id1, $id2)
    {
        return (boolean)ActReferenceQuery::create()
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
        $this->output->writeln('Finding reference counts');
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
        $this->output->writeln('Applying seriation');
        $matrix = [];
        foreach ($this->counts as $actId => $val) {
            foreach ($this->counts as $actId2 => $val2) {
                $matrix[$actId][$actId2] = $this->matrix[$actId][$actId2];
            }
        }
        $this->matrix = $matrix;
        return $this;

    }

    private function calculateWeights()
    {
        $this->output->writeln('Calculating weights');

//        $this->matrix = [
//            0 => [
//                0 => 1,
//                1 => 1,
//                2 => 0,
//                3 => 0,
//                4 => 1,
//                5 => 1,
//                6 => 1,
//                7 => 1,
//                8 => 1,
//            ],
//            1 => [
//                0 => 1,
//                1 => 0,
//                2 => 1,
//                3 => 1,
//                4 => 0,
//                5 => 0,
//                6 => 0,
//                7 => 0,
//                8 => 0,
//            ],
//            2 => [
//                0 => 0,
//                1 => 1,
//                2 => 0,
//                3 => 0,
//                4 => 0,
//                5 => 0,
//                6 => 0,
//                7 => 0,
//                8 => 0,
//            ],
//            3 => [
//                0 => 0,
//                1 => 1,
//                2 => 0,
//                3 => 0,
//                4 => 0,
//                5 => 0,
//                6 => 0,
//                7 => 0,
//                8 => 0,
//            ],
//            4 => [
//                0 => 1,
//                1 => 0,
//                2 => 0,
//                3 => 0,
//                4 => 0,
//                5 => 0,
//                6 => 0,
//                7 => 0,
//                8 => 0,
//            ],
//            5 => [
//                0 => 1,
//                1 => 0,
//                2 => 0,
//                3 => 0,
//                4 => 0,
//                5 => 0,
//                6 => 0,
//                7 => 0,
//                8 => 0,
//            ],
//            6 => [
//                0 => 1,
//                1 => 0,
//                2 => 0,
//                3 => 0,
//                4 => 0,
//                5 => 0,
//                6 => 0,
//                7 => 0,
//                8 => 0,
//            ],
//            7 => [
//                0 => 1,
//                1 => 0,
//                2 => 0,
//                3 => 0,
//                4 => 0,
//                5 => 0,
//                6 => 0,
//                7 => 0,
//                8 => 0,
//            ],
//            8 => [
//                0 => 1,
//                1 => 0,
//                2 => 0,
//                3 => 0,
//                4 => 0,
//                5 => 0,
//                6 => 0,
//                7 => 0,
//                8 => 0,
//            ],
//        ];

        $weights = [];
        foreach ($this->matrix as $actId => $val) {
            // map for each act searchable values
            $searches = [];
            foreach ($this->matrix as $actId2 => $val2) {
                $searches[$actId][$actId2] = $this->matrix[$actId][$actId2];
            }
            // iterate over entire matrix to find for mapped search values count
            $counts = [];
            foreach ($this->matrix as $actId3 => $val3) {
                $search = $searches[$actId][$actId3];
                $count = 0;
                foreach ($this->matrix as $actId4 => $val4) {
                    if ($search === $this->matrix[$actId3][$actId4]) {
                        $count++;
                    }
                }
                $counts[] = $count;
            }
            $weights[$actId] = array_sum($counts);
        }

        // store weights to db
        foreach ($weights as $actId => $weight) {
            ActQuery::create()
                ->filterById($actId)
                ->findOne()
                ->setConfirmityWeight($weight)
                ->save()
            ;
        }
    }
}
