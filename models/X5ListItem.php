<?php

class X5ListItem extends SimpleORMap
{
    protected static function configure($config = array())
    {
        $config['db_table'] = 'x5_list_items';
        parent::configure($config);
    }
}
