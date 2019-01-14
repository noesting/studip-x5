<?php

namespace Argonauts\x5\Routes\Lists;

use Argonauts\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlterX5List extends JsonApiController
{
    public function __invoke(Request $request, Response $response, $args)
    {
        // if (!$lists = X5List::find($args['id'])) {
        //     throw new RecordNotFoundException();
        // }

        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        // return $this->getContentResponse($lists);

        return json_encode(array('AlterX5List' => $args['id']));
    }
}
