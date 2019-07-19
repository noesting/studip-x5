<?php

namespace X5\Schemas;

use JsonApi\Schemas\SchemaProvider;
use Neomerx\JsonApi\Document\Link;

class X5ListItem extends SchemaProvider
{
    const TYPE = 'x5-listitems';
    protected $resourceType = self::TYPE;

    public function getId($resource)
    {
        return $resource->getId($resource);
    }

    public function getAttributes($resource)
    {
        return [
            'comment' => $resource['comment'],
            'mkdate' => date('c', $resource['mkdate']),
            'chdate' => date('c', $resource['chdate']),
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'x5list' => [
                self::DATA => $resource->x5list,
                self::LINKS => [Link::RELATED => new Link('/x5list/' . $resource->list_id) . '/show'],
            ],
            'x5-item' => [
                self::DATA => $resource->x5item,
                self::LINKS => [LINK::RELATED => new Link('/x5item/' . $resource->item_id . '/show')],
            ],
        ];
    }
}
