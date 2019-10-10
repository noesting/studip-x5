<?php

namespace X5\Routes\Lists;

use JsonApi\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetX5List extends JsonApiController
{
    public function __invoke(Request $request, Response $response, $args)
    {
        global $perm;
        $x5lists = X5List::find($args['id']);

        // if (!$lists = X5List::find($args['id'])) {
        //     throw new RecordNotFoundException();
        // }

        if (!$perm->have_studip_perm('dozent', $x5lists->course->id)) {
            throw new AuthorizationFailedException();
        };    

        // return $this->getContentResponse($lists);

        return json_encode(array('GetX5List' => $args['id']));
    }
}
