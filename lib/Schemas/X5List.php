<?php

namespace X5\Schemas;

use Argonauts\Schemas\SchemaProvider;

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
            'range_id' => $resource['range_id'],
            'position' => (int) $resource['position'],
            'mkdate' => date('c', $resource['mkdate']),
            'chdate' => date('c', $resource['chdate']),
            'visible' => (boolean) $resource['visible'],
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [];
    }
}
