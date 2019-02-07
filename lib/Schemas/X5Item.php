<?php

namespace X5\Schemas;

use Argonauts\Schemas\SchemaProvider;

class X5Item extends SchemaProvider
{
    const TYPE = 'x5-items';
    protected $resourceType = self::TYPE;

    public function getId($resource)
    {
        return $resource->getId($resource);

    }

    public function getAttributes($resource)
    {
        return [
            // 'title' => $resource['title'],
            // 'description' => $resource['description'],
            // 'author' => $resource['author'],
            // 'publishing-year' => $resource['publishingYear'],
            // 'link' => $resource['link'],
            // 'thumbs-ups' => (int) $resource['thumbsUps'],
            // 'thumbnail' => $resource['thumbnail'],
            // 'item_id' => $resource['item_id'],
            // 'likes' => $resource['likes'],
            'mkdate' => date('c', $resource['mkdate']),
            'chdate' => date('c', $resource['chdate']),
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [];
    }
}
