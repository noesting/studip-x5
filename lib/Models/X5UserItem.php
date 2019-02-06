<?php

namespace X5\Models;

class X5UserItem extends \SimpleORMap
{
    protected static function configure($config = array())
    {
        $config['db_table'] = 'x5_user_items';
        $config['belongs_to']['user'] = array(
            'class_name' => \User::class,
            'foreign_key' => 'user_id',
        );
        $config['belongs_to']['x5item'] = array(
            'class_name' => X5Item::class,
            'foreign_key' => 'item_id',
            'assoc_func' => 'findById',
        );
        parent::configure($config);
    }
}
