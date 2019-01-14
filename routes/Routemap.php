<?php

namespace Argonauts\x5;

include 'x5lists/GetX5List.php';
include 'x5lists/GetX5Lists.php';
include 'x5lists/RemoveX5List.php';
include 'x5lists/AlterX5List.php';
include 'x5lists/AddX5List.php';
include 'x5items/GetX5Item.php';
include 'x5items/AddX5Item.php';
include 'x5items/AlterX5Item.php';
include 'x5items/RemoveX5Item.php';

use Argonauts\x5\Routes\Items;
use Argonauts\x5\Routes\Lists;

class Routemap
{
    public static function registerAuthenticatedRoutes(\Slim\App $app)
    {
        $app->get('/list', Lists\GetX5List::class);
        $app->get('/lists', Lists\GetX5Lists::class);
        $app->get('/list/add', Lists\AddX5List::class);
        $app->get('/list/alter', Lists\AlterX5List::class);
        $app->get('/list/remove', Lists\RemoveX5List::class);

        $app->get('/item', Items\GetX5Item::class);
        $app->get('/item/add', Items\AddX5Item::class);
        $app->get('/item/alter', Items\AlterX5Item::class);
        $app->get('/item/remove', Items\RemoveX5Item::class);
    }
}
