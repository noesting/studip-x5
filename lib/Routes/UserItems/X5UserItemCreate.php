<?php

namespace X5\Routes\UserItems;

use JsonApi\JsonApiController;
use JsonApi\Routes\ValidationTrait;
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
        global $perm;

        if (!$perm->have_perm('user')) {
            throw new AuthorizationFailedException();
        };

        $user_id = $this->getUser($request)->id;
        if ($find = X5UserItem::findOneBySql('user_id = ? AND item_id = ?', [$user_id, $args['id']])) {
            return 'Item Exists already';
        }

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
        $read = self::arrayGet($json, 'data.attributes.read');
        $item_id = self::arrayGet($json, 'data.relationships.x5-item.id');
        $user_id = $this->getUser($request)->id;

        return $this->createX5UserItem($item_id, $user_id, $likes, $read);
    }

    private function createX5UserItem($item_id, $user_id, $likes, $read)
    {
        $currentTime = time();
        return X5UserItem::create(
            [
                'item_id' => $item_id,
                'user_id' => $user_id,
                'likes' => $likes,
                'read' => $read,
                'mkdate' => $currentTime,
                'chdate' => $currentTime,
            ]
        );
    }
}
