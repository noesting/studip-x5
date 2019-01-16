<?php

namespace X5\Models;

class X5ItemDummy implements \ArrayAccess
{
    public function __construct($json)
    {
        foreach ($json as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function offsetExists($offset)
    {
        return true;
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value)
    {

    }

    public function offsetUnset($offset)
    {

    }
}
