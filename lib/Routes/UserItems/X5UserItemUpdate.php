<?php

namespace X5\Routes\ListItems;

use JsonApi\JsonApiController;
use JsonApi\Routes\ValidationTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5UserItem;
use X5\Schemas\X5Item as X5ItemSchema;
use X5\Schemas\X5UserItem as X5UserItemSchema;
//import RecordNotFoundException

class X5UserItemUpdate extends JsonApiController
{
    use ValidationTrait;
    public function __invoke(Request $request, Response $response, $args)
    {
        if (!$X5UserItem = X5UserItem::findOneBySql('item_id = ? AND list_id = ?', [$args['item_id'], $args['list_id']])) {
            throw new RecordNotFoundException();
        }

        // TODO Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        $result = $this->updateX5UserItem($request, $X5UserItem);

        return $this->getCreatedResponse($result);
    }

    public function updateX5UserItem($request, $X5UserItem)
    {
        $json = $this->validate($request);
        $read = self::arrayGet($json, 'data.attributes.read');
        $X5UserItem->read = $read;

        $X5UserItem->store();
        return $X5UserItem;
    }

    protected function validateResourceDocument($json, $data)
    {
        if (!$this->validateResourceObject($json, 'data', X5UserItemSchema::TYPE)) {
            return 'Missing primary resource object.';
        }
    }
}
