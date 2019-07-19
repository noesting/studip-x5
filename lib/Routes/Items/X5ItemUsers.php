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

        $liked = X5UserItem::findOneBySql('user_id = ? AND item_id = ?', [$user, $args['id']]);

        if ($liked) {
            $iLiked = true;
        } else {
            $iLiked = false;
        }

        // TODO Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        $meta = ['likes' => count($likes), 'liked' => $iLiked];

        return $this->getMetaResponse($meta);
    }
}
