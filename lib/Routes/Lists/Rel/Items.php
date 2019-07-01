<?php

namespace X5\Routes\Lists\Rel;

use JsonApi\Errors\RecordNotFoundException;
use JsonApi\Routes\RelationshipsController;
use Psr\Http\Message\ServerRequestInterface as Request;
use X5\Models\X5Item;
use X5\Models\X5List;
use X5\Models\X5ListItem;
use X5\Schemas\X5Item as ItemSchema;

class Items extends RelationshipsController
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function fetchRelationship(Request $request, $related)
    {
        $items = $this->getItems($this->getUser($request), $related);
        $total = count($items);
        list($offset, $limit) = $this->getOffsetAndLimit();

        return $this->getPaginatedIdentifiersResponse(
            array_slice($items, $offset, $limit),
            $total,
            $this->getRelationshipLinks($related)
        );
    }

    protected function addToRelationship(Request $request, $related)
    {
        $json = $this->validate($request);

        $items = $this->validateItems($this->getUser($request), $related, $json);
        $this->addItems($related, $items);

        return $this->getCodeResponse(204);
    }

    protected function removeFromRelationship(Request $request, $related)
    {
        $json = $this->validate($request);
        $items = $this->validateItems($this->getUser($request), $related, $json);
        $this->removeItems($related, $items);

        return $this->getCodeResponse(204);
    }

    protected function replaceRelationship(Request $request, $related)
    {
        $json = $this->validate($request);
        $items = $this->validateItems($this->getUser($request), $related, $json);
        $this->replaceItems($related, $items);

        return $this->getCodeResponse(204);
    }

    protected function findRelated(array $args)
    {
        if (!$related = X5List::find($args['id'])) {
            throw new RecordNotFoundException();
        }

        return $related;
    }

    protected function authorize(Request $request, $resource)
    {
        return true;

        // TODO do authorization
        switch ($request->getMethod()) {
            case 'GET':
                return Authority::canShowNews($this->getUser($request), $resource);

            case 'PATCH':
            case 'POST':
            case 'DELETE':
                return Authority::canEditNews($this->getUser($request), $resource);

            default:
                return false;
        }
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getRelationshipSelfLink($resource, $schema, $userData)
    {
        return $schema->getRelationshipSelfLink($resource, 'items');
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function getRelationshipRelatedLink($resource, $schema, $userData)
    {
        return $schema->getRelationshipRelatedLink($resource, 'items');
    }

    private function getItems(\User $user, X5List $list)
    {
        return $list->list_items->map(function ($list_item) {
            // return $list_item->item;
            return X5Item::find($list_item->item_id);
        });
    }

    protected function validateResourceDocument($json, $data)
    {
        if (!self::arrayHas($json, 'data')) {
            return 'Missing `data` member at document´s top level.';
        }

        $data = self::arrayGet($json, 'data');

        if (!is_array($data)) {
            return 'Document´s ´data´ must be an array.';
        }

        foreach ($data as $item) {
            if (!self::arrayGet($item, 'type') === ItemSchema::TYPE) {
                return 'Wrong `type` in document´s `data`.';
            }

            if (!self::arrayGet($item, 'id')) {
                return 'Missing `id` of document´s `data`.';
            }
        }

        if (self::arrayHas($json, 'data.attributes')) {
            return 'Document must not have `attributes`.';
        }
    }

    private function validateItems(\User $user, X5List $list, $json)
    {
        $items = [];

        foreach (self::arrayGet($json, 'data') as $itemResource) {
            if (!$item = $this->findItem($itemResource['type'], $itemResource['id'])) {
                throw new RecordNotFoundException();
            }

            // if (!Authority::canEditNewsRange($user, $list, $item->id)) {
            //     throw new AuthorizationFailedException();
            // }

            $items[] = $item;
        }

        return $items;
    }

    private function findItem($type, $itemId)
    {
        return X5Item::find($itemId);
    }

    private function addItems(X5List $list, array $items)
    {
        foreach ($items as $item) {
            $listitem = X5ListItem::findOneBySQL('list_id = ? AND item_id = ?', [$list->id, $item->id]);
            if (!$listitem) {
                X5ListItem::create([
                    "list_id" => $list->id,
                    "item_id" => $item->id,
                ]);
            }
        }

        $list->resetRelation('list_items');
    }

    private function removeItems(X5List $list, array $items)
    {
        $ids = array_map(function ($item) {
            return $item instanceof \SimpleORMap ? $item->getId() : $item;
        }, $items);

        if (!empty($ids)) {
            X5ListItem::deleteBySql('list_id = ? AND item_id IN (?)', [$list->id, $ids]);
            $list->resetRelation('list_items');
        }
    }

    private function replaceItems(X5List $list, array $items)
    {
        $oldItemIds = $list->list_items->map(function ($list_item) {
            return $list_item->item_id;
        });

        $newItemIds = array_map(
            function ($item) {
                return $item->getId();
            },
            $items
        );

        $this->removeItems($list, array_diff($oldItemIds, $newItemIds));
        $this->addItems($list, array_diff($newItemIds, $oldItemIds));

        $list->resetRelation('list_items');
    }
}
