<?php

namespace X5\Routes\Lists;

use Argonauts\JsonApiController;
use Argonauts\Routes\ValidationTrait;
use Argonauts\Schemas\Course as CourseSchema;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5Item;
use X5\Models\X5List;
use X5\Models\X5ListItem;
use X5\Schemas\X5List as X5ListSchema;

class X5ListItemsAdd extends JsonApiController
{
    use ValidationTrait;
    public function __invoke(Request $request, Response $response, $args)
    {
        if (!$x5list = X5List::find($args['id'])) {
            throw new RecordNotFoundException();
        }

        $itemIdsToAdd = $this->getItemsToAdd($request, $x5list);

        $this->clearList($args['id']);

        for ($i = 0; $i < count($itemIdsToAdd); $i++) {
            if (!$this->x5itemExists($itemIdsToAdd[$i])) {
                $this->createX5Item($itemIdsToAdd[$i]);
            }

            if (!$this->listItemExists($args['id'], $itemIdsToAdd[$i])) {
                $this->addListItem($args['id'], $itemIdsToAdd[$i]);
            }
        }

        // TODO Authorization
        // if (1 == 2) {
        //     throw new AuthorizationFailedException();
        // }

        // $result = $this->updateX5List($request, $x5list);

        return $this->getCodeResponse(204);
    }

    public function clearList($list_id)
    {
        $x5ListItems = X5ListItem::findManyByList_id($list_id);
        for ($i = 0; $i < count($x5ListItems); $i++) {
            $x5ListItems[$i]->delete();
        }
    }

    public function listItemExists($list_id, $item_id)
    {
        $items = X5ListItem::findBySQL('item_id = ? AND list_id = ?', [$item_id, $list_id]);
        if ($items) {
            return true;
        }

        return false;
    }

    public function addListItem($list_id, $item_id)
    {
        $x5ListItem = new X5ListItem();
        $x5ListItem->item_id = $item_id;
        $x5ListItem->list_id = $list_id;

        $now = time();
        $x5ListItem->mkdate = $now;
        $x5ListItem->chdate = $now;

        $x5ListItem->position = 0;

        $x5ListItem->store();
    }

    private function x5itemExists($itemId)
    {
        $x5item = X5Item::find($itemId);
        if ($x5item) {
            return true;
        }

        return false;
    }

    private function createX5Item($itemId)
    {
        $currentTime = time();
        return X5Item::create(
            [
                'item_id' => $itemId,
                'mkdate' => $currentTime,
                'chdate' => $currentTime,
                'likes' => 0,
            ]
        );
    }

    public function getItemsToAdd($request, $x5list)
    {
        $json = $this->validate($request);

        $x5Items = self::arrayGet($json, 'data.relationships.x5items');
        $idsToAdd = [];
        for ($i = 0; $i < count($x5Items); $i++) {
            $idToAdd = self::arrayGet($x5Items[$i], 'id');
            $idsToAdd[] = $idToAdd;
        }

        return $idsToAdd;
    }

    protected function validateResourceDocument($json, $data)
    {
        if (!$this->validateResourceObject($json, 'data', X5ListSchema::TYPE)) {
            return 'Missing primary resource object.';
        }

        // Attribute: title
        if (!$title = self::arrayGet($json, 'data.attributes.title', '')
            || !mb_strlen(trim($title))) {
            return '`title` must not be empty.';
        }

        // Relationship: course
        if (!$this->validateResourceObject($json, 'data.relationships.course', CourseSchema::TYPE)) {
            return 'Missing `course` relationship';
        }

        // Relationship: X5Items
        // if (!$this->validateResourceObject($json, 'data.relationships.x5items', null)) {
        //     return '`x5items` must not be empty.';
        // }
    }
}
