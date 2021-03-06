<?php

namespace X5\Routes\UserItems;

use Argonauts\Errors\RecordNotFoundException;
use Argonauts\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5UserItem;

class X5UserItemDelete extends JsonApiController
{
    public function __invoke(Request $request, Response $response, $args)
    {
        $user_id = $this->getUser($request)->id;
        if (!$userItem = X5UserItem::findOneBySql('user_id = ? AND item_id = ?', [$user_id, $args['id']])) {
            throw new RecordNotFoundException();
        }

        // TODO: Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        if (!$userItem->delete()) {
            throw new InternalServerError('Could not delete x5list.');
        }

        return $this->getCodeResponse(204);
    }
}
