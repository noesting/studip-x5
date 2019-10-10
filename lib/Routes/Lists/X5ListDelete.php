<?php

namespace X5\Routes\Lists;

use JsonApi\Errors\RecordNotFoundException;
use JsonApi\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5List;

class X5ListDelete extends JsonApiController
{
    public function __invoke(Request $request, Response $response, $args)
    {
        global $perm;

        if (!$list = X5List::find($args['id'])) {
            throw new RecordNotFoundException();
        }

        if (!$perm->have_studip_perm('dozent', $list->course->id)) {
            throw new AuthorizationFailedException();
        };     

        if (!$list->delete()) {
            throw new InternalServerError('Could not delete x5list.');
        }

        return $this->getCodeResponse(204);
    }
}
