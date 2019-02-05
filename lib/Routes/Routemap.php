<?php

namespace X5\Routes;

class Routemap
{
    public static function registerAuthenticatedRoutes(\Slim\App $app)
    {
        Routemap::registerCoursesRoutes($app);
        Routemap::registerX5ListRoutes($app);
        Routemap::registerX5ItemRoutes($app);
    }

    public static function registerCoursesRoutes(\Slim\App $app)
    {
        $app->get('/courses/{range_id}/x5lists', Lists\GetX5Lists::class);
        // TODO: handle other role in route
        $app->get('/courses/{id}/x5lists/student', Lists\StudentGetX5Lists::class);
    }

    public static function registerX5ListRoutes(\Slim\App $app)
    {
        $app->get('/x5list/{id}/show', Lists\GetX5List::class);
        $app->get('/x5list/{id}/items', Lists\GetItemsFromList::class);
        $app->post('/x5list/{id}/items/add', Lists\AddItemsToList::class);
        $app->post('/x5list/add', Lists\AddX5List::class);
        $app->patch('/x5list/{id}/update', Lists\AlterX5List::class);
        $app->delete('/x5list/{id}/remove', Lists\RemoveX5List::class);
    }

    public static function registerX5ItemRoutes(\Slim\App $app)
    {
        $app->get('/x5item/{id}/show', Items\GetX5Item::class);
        $app->get('/x5item/add', Items\AddX5Item::class);
        $app->get('/x5item/{id}/alter', Items\AlterX5Item::class);
        $app->get('/x5item/{id}/remove', Items\RemoveX5Item::class);
    }
}
