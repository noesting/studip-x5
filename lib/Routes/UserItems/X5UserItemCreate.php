<?php

namespace X5\Routes\UserItems;

use Argonauts\JsonApiController;
use Argonauts\Routes\ValidationTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5UserItem;
use X5\Schemas\X5Item as X5ItemSchema;
use X5\Schemas\X5UserItem as X5UserItemSchema;

class X5UserItemCreate extends JsonApiController
{
    use ValidationTrait;
    public function __invoke(Request $request, Response $response, $args)
    {
        // TODO Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        $x5list = $this->addX5UserItem($request);

        return $this->getCreatedResponse($x5list);
    }

    protected function validateResourceDocument($json, $data)
    {
        if (!$this->validateResourceObject($json, 'data', X5UserItemSchema::TYPE)) {
            return 'Missing primary resource object.';
        }

        // // Attribute: likes
        // if (!$title = self::arrayGet($json, 'data.attributes.likes', false)) {
        //     return '`likes` must not be empty.';
        // }

        // Relationship: x5item
        if (!$this->validateResourceObject($json, 'data.relationships.x5-item.', X5ItemSchema::TYPE)) {
            return 'Missing `item` relationship';
        }

        // Relationship: user
        // if (!$this->validateResourceObject($json, 'data.relationships.user', UserSchema::TYPE)) {
        //     return 'Missing `user` relationship';
        // }
    }

    private function addX5UserItem($request)
    {
        $json = $this->validate($request);

        $likes = self::arrayGet($json, 'data.attributes.likes');
        $item_id = self::arrayGet($json, 'data.relationships.x5-item.id');
        $user_id = $this->getUser($request)->id;

        return $this->createX5UserItem($item_id, $user_id, $likes);
    }

    private function createX5UserItem($item_id, $user_id, $likes)
    {
        $currentTime = time();
        return X5UserItem::create(
            [
                'item_id' => $item_id,
                'user_id' => $user_id,
                'likes' => $likes,
                'mkdate' => $currentTime,
                'chdate' => $currentTime,
            ]
        );
    }
}
