<?php

namespace X5\Schemas;

use Argonauts\Schemas\SchemaProvider;
use Neomerx\JsonApi\Document\Link;
use X5\Models\X5ListItem;

class X5List extends SchemaProvider
{
    const TYPE = 'x5-lists';
    protected $resourceType = self::TYPE;

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
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        $relatedItems = X5ListItem::findManyByList_id($resource->id);
        $rels = [];

        for ($i = 0; $i < count($relatedItems); $i++) {
            $rels[] = ['type' => 'x5-items', 'id' => $relatedItems[$i]->item_id];
        }

        $x5itemrels = ['meta' => $rels];

        return [
            'course' => [
                self::DATA => $resource->course,
                self::LINKS => [Link::RELATED => new Link('/courses/' . $resource->range_id)],
            ],
            'x5-items' => $x5itemrels,
        ];
    }
}
