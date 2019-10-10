<?php

namespace X5\Routes\Courses;

use JsonApi\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5List;
use JsonApi\Errors\AuthorizationFailedException;

class CoursesX5ListsShowStudent extends JsonApiController
{
    public function __invoke(Request $request, Response $response, $args)
    {
        global $perm;

        if (!$perm->have_studip_perm('autor', Context::getId())) {
            throw new AuthorizationFailedException();
        }; 

        $now = time();
        if (!$lists = X5List::findBySQL('range_id = ? AND release_date <= ?', [$args['id'], $now])) {
            $lists = [];
        }

        return $this->getContentResponse($lists);
    }
}
