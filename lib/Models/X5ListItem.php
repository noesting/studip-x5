<?php

namespace X5\Models;

class X5ListItem extends \SimpleORMap
{
    protected static function configure($config = array())
    {
        $config['db_table'] = 'x5_list_items';
        $config['belongs_to']['x5list'] = array(
            'class_name' => 'X5List',
            'foreign_key' => 'list_id',
        );
        parent::configure($config);
    }
}
