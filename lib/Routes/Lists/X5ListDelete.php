<?php

namespace X5\Routes\Lists;

use Argonauts\Errors\RecordNotFoundException;
use Argonauts\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5List;

class X5ListDelete extends JsonApiController
{
    public function __invoke(Request $request, Response $response, $args)
    {
        if (!$list = X5List::find($args['id'])) {
            throw new RecordNotFoundException();
        }

        // TODO: Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        if (!$list->delete()) {
            throw new InternalServerError('Could not delete x5list.');
        }

        return $this->getCodeResponse(204);
    }
}
