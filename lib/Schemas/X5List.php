<?php

namespace X5\Schemas;

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
            'range_id' => $resource['range_id'],
            'position' => (int) $resource['position'],
            'mkdate' => date('c', $resource['mkdate']),
            'chdate' => date('c', $resource['chdate']),
            'visible' => (boolean) $resource['visible'],
        ];
    }
}

//             `id` int(11) NOT NULL AUTO_INCREMENT,
//             `range_id` varchar(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
//             `position` int(10) unsigned NOT NULL,
//             `mkdate` int(11) NOT NULL DEFAULT '0',
//             `chdate` int(11) NOT NULL DEFAULT '0',
//             `visible` boolean NOT NULL,
