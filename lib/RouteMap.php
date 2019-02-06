<?php

namespace X5;

trait RouteMap
{
    public function registerAuthenticatedRoutes(\Slim\App $app)
    {
        $this->registerCoursesRoutes($app);
        $this->registerX5ListRoutes($app);
        $this->registerX5ItemRoutes($app);
    }

    private function registerCoursesRoutes(\Slim\App $app)
    {
        $app->get('/courses/{range_id}/x5lists', Routes\Courses\CoursesX5ListsShow::class);
        // TODO: handle other role in route
        $app->get('/courses/{id}/x5lists/student', Routes\Courses\CoursesX5ListsShowStudent::class);
    }

    private function registerX5ListRoutes(\Slim\App $app)
    {
        $app->get('/x5list/{id}/show', Routes\Lists\X5ListShow::class);
        $app->get('/x5list/{id}/items', Routes\Lists\X5ListItemsShow::class);
        $app->post('/x5list/{id}/items/add', Routes\Lists\X5ListItemsAdd::class);
        $app->post('/x5list', Routes\Lists\X5ListCreate::class);
        $app->patch('/x5list/{id}/update', Routes\Lists\X5ListUpdate::class);
        $app->delete('/x5list/{id}/delete', Routes\Lists\X5ListDelete::class);

        $app->map(['GET', 'PATCH', 'POST', 'DELETE'], '/x5-lists/{id}/relationships/x5-items', Routes\Lists\Rel\Items::class);
    }

    private function registerX5ItemRoutes(\Slim\App $app)
    {
        $app->get('/x5item/{id}/show', Routes\Items\X5ItemShow::class);
        $app->get('/x5item/create', Routes\Items\X5ItemCreate::class);
        $app->get('/x5item/{id}/update', Routes\Items\X5ItemUpdate::class);
        $app->get('/x5item/{id}/delete', Routes\Items\X5ItemDelete::class);
    }

    public function registerUnauthenticatedRoutes(\Slim\App $app)
    {}

    public function registerSchemas()
    {
        return [
            Models\X5List::class => Schemas\X5List::class,
            Models\X5ListItem::class => Schemas\X5ListItem::class,
            Models\X5Item::class => Schemas\X5Item::class,
        ];
    }
}
