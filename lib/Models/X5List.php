<?php

namespace X5\Models;

class X5List extends \SimpleORMap
{
    protected static function configure($config = array())
    {
        $config['db_table'] = 'x5_lists';
        $config['belongs_to']['course'] = array(
            'class_name' => 'Course',
            'foreign_key' => 'range_id',
        );
        $config['has_many']['list_items'] = array(
            'class_name' => X5ListItem::class,
            'assoc_func' => 'findByList_id',
        );
        parent::configure($config);
    }
}
