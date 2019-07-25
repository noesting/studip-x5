<?php

namespace X5\Routes\Items;

use JsonApi\JsonApiController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5UserItem;

class X5ItemUsers extends JsonApiController
{
    public function __invoke(Request $request, Response $response, $args)
    {
        if (!$likes = X5UserItem::findManyByItem_id($args['id'])) {
            $likes = [];
        }

        $user = $this->getUser($request)->id;

        $like = X5UserItem::findOneBySql('user_id = ? AND item_id = ? AND likes = 1', [$user, $args['id']]);

        if ($like) {
            $iLiked = true;
        } else {
            $iLiked = false;
        }
        
        // x5_user_items.read > got error without table "x5_user_items"
        $read = X5UserItem::findOneBySql('user_id = ? AND item_id = ? AND x5_user_items.read = 1', [$user, $args['id']]);

        if ($read) {
            $iRead = true;
        } else {
            $iRead = false;
        }        

        // TODO Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        $meta = ['likes' => count($likes), 'liked' => $iLiked, 'read' => $iRead];

        return $this->getMetaResponse($meta);
    }
}
