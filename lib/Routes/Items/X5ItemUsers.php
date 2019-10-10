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
        global $perm;

        if (!$perm->have_perm('autor')) {
            throw new AuthorizationFailedException();
        };

        if (!$likes = X5UserItem::findBySQL('item_id = ? AND likes = 1', [$args['id']])) {
            $likes = [];
        }

        $user = $this->getUser($request)->id;

        $like = X5UserItem::findOneBySql('user_id = ? AND item_id = ? AND likes = 1', [$user, $args['id']]);

        if ($like) {
            $iLiked = true;
        } else {
            $iLiked = false;
        }
        
        $read = X5UserItem::findOneBySql('user_id = ? AND item_id = ? AND x5_user_items.read = 1', [$user, $args['id']]);

        if ($read) {
            $iRead = true;
        } else {
            $iRead = false;
        }

        $meta = ['likes' => count($likes), 'liked' => $iLiked, 'read' => $iRead];

        return $this->getMetaResponse($meta);
    }
}
