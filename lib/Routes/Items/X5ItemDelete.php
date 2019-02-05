<?php

namespace X5\Routes\Items;

use Argonauts\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class X5ItemDelete extends JsonApiController
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

        return json_encode(array('RemoveX5Item' => $args['id']));
    }
}
