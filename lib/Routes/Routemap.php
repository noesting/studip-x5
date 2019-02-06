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
        $app->get('/courses/{range_id}/x5lists', Courses\CoursesX5ListsShow::class);
        // TODO: handle other role in route
        $app->get('/courses/{id}/x5lists/student', Courses\CoursesX5ListsShowStudent::class);
    }

    public static function registerX5ListRoutes(\Slim\App $app)
    {
        $app->get('/x5list/{id}/show', Lists\X5ListShow::class);
        $app->get('/x5list/{id}/items', Lists\X5ListItemsShow::class);
        $app->post('/x5list/{id}/items/add', Lists\X5ListItemsAdd::class);
        $app->post('/x5list/create', Lists\X5ListCreate::class);
        $app->patch('/x5list/{id}/update', Lists\X5ListUpdate::class);
        $app->delete('/x5list/{id}/delete', Lists\X5ListDelete::class);
    }

    public static function registerX5ItemRoutes(\Slim\App $app)
    {
        $app->get('/x5item/{id}/show', Items\X5ItemShow::class);
        $app->get('/x5item/create', Items\X5ItemCreate::class);
        $app->get('/x5item/{id}/update', Items\X5ItemUpdate::class);
        $app->get('/x5item/{id}/delete', Items\X5ItemDelete::class);
    }
}
