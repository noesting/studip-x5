<?php

namespace X5\Routes\Courses;

use JsonApi\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5List;
use JsonApi\Errors\AuthorizationFailedException;

class CoursesX5ListsShow extends JsonApiController
{
    public function __invoke(Request $request, Response $response, $args)
    {
        global $perm;

        //TODO: other role?
        if (!$perm->have_studip_perm('student', $args['range_id'])) {
            throw new AuthorizationFailedException();
        };

        if (!$lists = X5List::findManyByRange_id($args['range_id'])) {
            $lists = [];
        }

        return $this->getContentResponse($lists);
    }
}
