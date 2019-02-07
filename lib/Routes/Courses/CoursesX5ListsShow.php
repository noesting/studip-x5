<?php

namespace X5\Routes\Courses;

use Argonauts\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5List;

class CoursesX5ListsShow extends JsonApiController
{
    public function __invoke(Request $request, Response $response, $args)
    {
        if (!$lists = X5List::findManyByRange_id($args['range_id'])) {
            $lists = [];
        }

        // TODO Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        return $this->getContentResponse($lists);
    }
}
