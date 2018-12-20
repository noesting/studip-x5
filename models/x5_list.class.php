<?php

class X5List extends SimpleORMap
{
    protected static function configure($config = array())
    {
        $config['db_table'] = 'x5_lists';
        parent::configure($config);
    }
}
