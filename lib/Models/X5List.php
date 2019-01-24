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
        parent::configure($config);
    }
}
