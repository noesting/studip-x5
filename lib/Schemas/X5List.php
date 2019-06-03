<?php

namespace X5\Schemas;

use Argonauts\Schemas\SchemaProvider;
use Neomerx\JsonApi\Document\Link;

class X5List extends SchemaProvider
{
    const TYPE = 'x5-lists';
    protected $resourceType = self::TYPE;

    const REL_COURSE = 'course';
    const REL_X5ITEMS = 'x5-items';

    public function getId($resource)
    {
        return $resource->getId($resource);

    }

    public function getAttributes($resource)
    {
        return [
            'title' => $resource['title'],
            'position' => (int) $resource['position'],
            'mkdate' => date('c', $resource['mkdate']),
            'chdate' => date('c', $resource['chdate']),
            'visible' => (boolean) $resource['visible'],
            'release-date' => date('c', $resource['release_date']),
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        $relationships = [];

        if ($isPrimary) {
            $relationships = $this->addCourseRelationship($relationships, $resource, $includeRelationships);
            $relationships = $this->addX5itemsRelationship($relationships, $resource, $includeRelationships);
        }

        return $relationships;
    }

    private function addCourseRelationship($relationships, $resource, $includeRelationships)
    {
        $data = $resource->course;
        $relationships[self::REL_COURSE] = [
            self::LINKS => [
                LINK::RELATED => new Link('/courses/' . $resource->range_id),
            ],
            self::DATA => $data,
        ];

        return $relationships;
    }

    private function addX5itemsRelationship($relationships, $resource, $includeRelationships)
    {
        $relatedX5Items = $resource->list_items->map(function ($list_item) {
            return $list_item->x5item;
        });

        $meta = $resource->list_items->map(function ($list_item) {
            return ['item_id' => $list_item->item_id, 'comment' => $list_item->comment];
        });

        $relationships[self::REL_X5ITEMS] = [
            self::DATA => $relatedX5Items,
            self::LINKS => [
                LINK::SELF => new Link('/x5list/' . $resource->getId() . '/relationships/items'),
                LINK::SELF => $this->getRelationshipSelfLink($resource, self::REL_X5ITEMS),
            ],
            self::META => $meta,
        ];

        return $relationships;
    }
}
