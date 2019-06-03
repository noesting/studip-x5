<?php

namespace X5\Models;

class X5Item extends \SimpleORMap
{
    protected static function configure($config = array())
    {
        $config['db_table'] = 'x5_items';
        parent::configure($config);
    }
}
