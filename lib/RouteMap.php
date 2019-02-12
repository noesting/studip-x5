<?php

namespace X5;

trait RouteMap
{
    public function registerAuthenticatedRoutes(\Slim\App $app)
    {
        $this->registerCoursesRoutes($app);
        $this->registerX5ListRoutes($app);
        $this->registerX5ItemRoutes($app);
        $this->registerX5ListItemRoutes($app);
        $this->registerX5UserItemRoutes($app);
    }

    private function registerCoursesRoutes(\Slim\App $app)
    {
        $app->get('/courses/{range_id}/x5-lists', Routes\Courses\CoursesX5ListsShow::class);
        // TODO: handle other role in route
        $app->get('/courses/{id}/x5-lists/student', Routes\Courses\CoursesX5ListsShowStudent::class);
    }

    private function registerX5ListRoutes(\Slim\App $app)
    {
        $app->get('/x5-lists/{id}/show', Routes\Lists\X5ListShow::class);
        $app->get('/x5-lists/{id}/items', Routes\Lists\X5ListItemsShow::class);
        $app->post('/x5-lists/{id}/items/add', Routes\Lists\X5ListItemsAdd::class);
        $app->post('/x5-lists/create', Routes\Lists\X5ListCreate::class);
        $app->patch('/x5-lists/{id}/update', Routes\Lists\X5ListUpdate::class);
        $app->delete('/x5-lists/{id}/delete', Routes\Lists\X5ListDelete::class);

        $app->map(['GET', 'PATCH', 'POST', 'DELETE'], '/x5-lists/{id}/relationships/x5-items', Routes\Lists\Rel\Items::class);
    }

    private function registerX5ItemRoutes(\Slim\App $app)
    {
        $app->get('/x5-items/{id}/show', Routes\Items\X5ItemShow::class);
        $app->get('/x5-items/create', Routes\Items\X5ItemCreate::class);
        $app->get('/x5-items/{id}/update', Routes\Items\X5ItemUpdate::class);
        $app->delete('/x5-items/{id}/delete', Routes\Items\X5ItemDelete::class);
        $app->get('/x5-items/{id}/users', Routes\Items\X5ItemUsers::class);
    }

    private function registerX5ListItemRoutes(\Slim\App $app)
    {
        $app->patch('/x5-list-items/{item_id}/{list_id}', Routes\ListItems\X5ListItemUpdate::class);
    }

    private function registerX5UserItemRoutes(\Slim\App $app)
    {
        $app->post('/x5-user-items/create', Routes\UserItems\X5UserItemCreate::class);
        $app->delete('/x5-user-items/{id}', Routes\UserItems\X5UserItemDelete::class);
    }

    public function registerUnauthenticatedRoutes(\Slim\App $app)
    {}

    public function registerSchemas()
    {
        return [
            Models\X5List::class => Schemas\X5List::class,
            Models\X5ListItem::class => Schemas\X5ListItem::class,
            Models\X5Item::class => Schemas\X5Item::class,
            Models\X5UserItem::class => Schemas\X5UserItem::class,
        ];
    }
}
