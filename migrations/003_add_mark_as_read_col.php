<?php

class AddMarkAsReadCol extends Migration
{
    public function up()
    {
        DBManager::get()->query("ALTER TABLE `x5_user_items` ADD COLUMN `read` tinyint(1) NOT NULL;");
    }

    public function down()
    {
        DBManager::get()->query("ALTER TABLE `x5_user_items` DROP COLUMN `read`;");
    }
}
