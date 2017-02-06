<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1461850676.
 * Generated on 2017-02-04 17:01:00 by tarmo
 */
class PropelMigration_1486306858
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

CREATE TABLE `act` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `act_reference` (
  `id` int(10) UNSIGNED NOT NULL,
  `source_act_id` int(10) UNSIGNED NOT NULL,
  `target_act_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `act`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `act_reference`
  ADD PRIMARY KEY (`id`),
  ADD KEY `source_act_id` (`source_act_id`),
  ADD KEY `target_act_id` (`target_act_id`);

ALTER TABLE `act`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `act_reference`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `act_reference`
  ADD CONSTRAINT `act_reference_ibfk_1` FOREIGN KEY (`source_act_id`) REFERENCES `act` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `act_reference_ibfk_2` FOREIGN KEY (`target_act_id`) REFERENCES `act` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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