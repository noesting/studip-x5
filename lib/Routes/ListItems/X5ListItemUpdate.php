<?php

namespace X5\Routes\ListItems;

use JsonApi\JsonApiController;
use JsonApi\Routes\ValidationTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5ListItem;
use X5\Schemas\X5ListItem as X5ListItemSchema;

class X5ListItemUpdate extends JsonApiController
{
    use ValidationTrait;
    public function __invoke(Request $request, Response $response, $args)
    {
        // if (!$x5listitrem = X5ListItem::find($args['id'])) {
        if (!$x5listitem = X5ListItem::findOneBySql('item_id = ? AND list_id = ?', [$args['item_id'], $args['list_id']])) {
            throw new RecordNotFoundException();
        }

        // TODO Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        $result = $this->updateX5ListItem($request, $x5listitem);

        return $this->getCreatedResponse($result);
    }

    public function updateX5ListItem($request, $x5listitem)
    {
        $json = $this->validate($request);
        $comment = self::arrayGet($json, 'data.attributes.comment');
        $x5listitem->comment = $comment;
        $x5listitem->chdate = time();

        $x5listitem->store();
        return $x5listitem;
    }

    protected function validateResourceDocument($json, $data)
    {
        if (!$this->validateResourceObject($json, 'data', X5ListItemSchema::TYPE)) {
            return 'Missing primary resource object.';
        }
    }
}
