<?php

namespace X5\Schemas;

use Argonauts\Schemas\SchemaProvider;
use Neomerx\JsonApi\Document\Link;

class X5UserItem extends SchemaProvider
{
    const TYPE = 'x5-useritems';
    protected $resourceType = self::TYPE;

    public function getId($resource)
    {
        return $resource->getId($resource);
    }

    public function getAttributes($resource)
    {
        return [
            'likes' => $resource['likes'],
            'mkdate' => date('c', $resource['mkdate']),
            'chdate' => date('c', $resource['chdate']),
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'x5list' => [
                self::DATA => $resource->user,
                // TODO use users/me route instead?
                self::LINKS => [Link::RELATED => new Link('/users/' . $resource->user_id)],
            ],
            'x5-item' => [
                self::DATA => $resource->item,
                self::LINKS => [LINK::RELATED => new Link('/x5item/' . $resource->item_id . '/show')],
            ],
        ];
    }
}
