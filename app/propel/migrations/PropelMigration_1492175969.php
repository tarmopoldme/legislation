<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1492175969.
 * Generated on 2017-04-14 16:19:13 by tarmo
 */
class PropelMigration_1492175969
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
    }

    /**
     * Calculate weight for acts which betweenness is 0
     * 1. Lowest betweenness weight is 0.024
     * 2. Take all acts which betweenness is 0 and order them by confirmity weight
     * 3. Decrease lowest betweenness by 0.0001 to get unique weight for all 0
     *
     * @param MigrationManager $manager
     */
    public function postUp(MigrationManager $manager)
    {
        $acts = \AppBundle\Model\ActQuery::create()
            ->filterByBetweennessWeight(0)
            ->orderByConfirmityWeight()
            ->find()
        ;

        $minBetweennessWeight = 0.024;

        foreach ($acts as $act) {
            $minBetweennessWeight = $minBetweennessWeight - 0.0001;
            $act
                ->setCombinedWeight($minBetweennessWeight)
                ->save()
            ;
        }
    }

    public function preDown(MigrationManager $manager)
    {
    }

    public function postDown(MigrationManager $manager)
    {
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `act` ADD `combined_weight` decimal(12,7) unsigned NULL AFTER `betweenness_weight`;
UPDATE `act` SET `combined_weight`=`betweenness_weight` WHERE `betweenness_weight` > 0;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
',
);
    }

}