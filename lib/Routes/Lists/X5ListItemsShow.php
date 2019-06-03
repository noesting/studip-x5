<?php

namespace X5\Routes\Lists;

use Argonauts\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5List;

class X5ListItemsShow extends JsonApiController
{
    public function __invoke(Request $request, Response $response, $args)
    {
        if (!$x5list = X5List::find($args['id'])) {
            throw new RecordNotFoundException();
        }

        // $x5ListItems = X5ListItem::findManyByList_id($args['id']);

        // // TODO Authorization
        // // if (1 == 2) {
        // //     throw new AuthorizationFailedException();
        // // }

        // $response->data = ['type' => 'x5lists', 'id' => $x5list->id];

        // $x5ListItemsJSONAPIFormat = [];
        // for ($i = 0; $i < count($x5ListItems); $i++) {
        //     $x5ListItemsJSONAPIFormat[] = ["type" => 'x5-items', 'id' => $x5ListItems[$id]->id, 'attributes' => ['comment' => $x5ListItems[$id]->comment]];
        // }

        // $rel = ['data' => $x5ListItemsJSONAPIFormat];
        // $response->relationships = ['x5-items' => $rel];

        return $this->getCreatedResponse($x5list);
    }
}
