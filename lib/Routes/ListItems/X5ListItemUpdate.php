<?php

namespace X5\Routes\ListItems;

use JsonApi\JsonApiController;
use JsonApi\Routes\ValidationTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5ListItem;
use X5\Schemas\X5ListItem as X5ListItemSchema;
use JsonApi\Errors\RecordNotFoundException;
use JsonApi\Errors\AuthorizationFailedException;

class X5ListItemUpdate extends JsonApiController
{
    use ValidationTrait;
    public function __invoke(Request $request, Response $response, $args)
    {
        global $perm;

        if (!$x5listitem = X5ListItem::findOneBySql('item_id = ? AND list_id = ?', [$args['item_id'], $args['list_id']])) {
            throw new RecordNotFoundException();
        }

        if (!$perm->have_studip_perm('dozent', $x5listitem->x5list->course->id)) {
            throw new AuthorizationFailedException();
        };     

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
