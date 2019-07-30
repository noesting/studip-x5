<?php

namespace X5\Routes\UserItems;

use JsonApi\JsonApiController;
use JsonApi\Routes\ValidationTrait;
use JsonApi\Errors\RecordNotFoundException;
use Jsonapi\Errors\UnprocessableEntityException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5UserItem;
use X5\Schemas\X5UserItem as X5UserItemSchema;

class X5UserItemUpdateLike extends JsonApiController
{
    use ValidationTrait;
    public function __invoke(Request $request, Response $response, $args)
    {
        $user_id = $this->getUser($request)->id;
        if (!$userItem = X5UserItem::findOneBySql('user_id = ? AND item_id = ?', [$user_id, $args['id']])) {
            throw new RecordNotFoundException('Not able to update an non-existing database entry (Call create instead');
        }

        // TODO Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        $result = $this->updateX5UserItem($request, $userItem);

        return $this->getCreatedResponse($result);
    }

    public function updateX5UserItem($request, $userItem)
    {
        $likeState = $userItem->likes;
        if ($likeState) {
          $userItem->likes = 0;
        } else{
          $userItem->likes = 1;
        }
        $userItem->store();
        return $userItem;
    }

    protected function validateResourceDocument($json, $data)
    {
      if (!$this->validateResourceObject($json, X5UserItemSchema::TYPE)) {
        throw new UnprocessableEntityException();
      }
    }
}
