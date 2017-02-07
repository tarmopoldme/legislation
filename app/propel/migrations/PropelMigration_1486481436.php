<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1486481436.
 * Generated on 2017-02-07 17:31:00 by tarmo
 */
class PropelMigration_1486481436
{
    public $comment = '';

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
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

ALTER TABLE `act` CHANGE `text` `text` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `act` ADD `xml` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER `text`;
ALTER TABLE `act_reference` ADD `reference_count` INT UNSIGNED NOT NULL AFTER `target_act_id`;

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