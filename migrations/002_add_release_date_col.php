<?php

class AddReleaseDateCol extends Migration
{
    public function up()
    {
        DBManager::get()->query("ALTER TABLE `x5_lists` ADD COLUMN `release_date` int(11) NOT NULL;");
    }

    public function down()
    {
        DBManager::get()->query("ALTER TABLE `x5_lists` DROP COLUMN `release_date`;");
    }
}
