<?php
namespace Dfossacecchi\HumbleMap;
use Dfossacecchi\HumbleMap\Exceptions\NotMappedException;

class Map implements \Iterator, \ArrayAccess, \Countable, \Serializable, \JsonSerializable
{
    protected $data = [];
    protected $i = 0;
    /**
     * Sets the strict mode, throwing exceptions if you access at data that does
     * not exists
     * @var bool
     */
    public static $strict = false;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    /**
     * Returns all data
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Returns keys
     * @return array
     */
    public function keys()
    {
        return array_keys($this->data);
    }
    
    /**
     * Returns values
     * @return array
     */
    public function values()
    {
        return array_values($this->data);
    }
    
    /**
     * Returns a flipped versoin of the current map
     * @return static
     */
    public function flip()
    {
        return new static(array_flip($this->data));
    }
    
    /**
     * Returns the value of the key
     * @param mixed $offset
     * @return mixed
     * @throws NotMappedException in strict mode if the offset does not exists as key
     */
    public function valueOf($offset)
    {
        if (array_key_exists($offset, $this->data)) {
            return $this->data[$offset];
        } else if (self::$strict) {
            throw new NotMappedException("Key $offset is not in map");
        } else {
            return null;
        }
    }
    
    /**
     * Return key of the value
     * @param mixed $offset
     * @return mixed
     * @throws NotMappedException in strict mode if the offset does not exists as value
     */
    public function keyOf($offset)
    {
        $flip = array_flip($this->data);
        if (array_key_exists($offset, $flip)) {
            return $flip[$offset];
        } else if (self::$strict) {
            throw new NotMappedException("Value $offset is not in map");
        } else {
            return null;
        }
    }
    
    public function keyIndex($key)
    {
        return array_search($key, $this->keys(), true);
    }
    
    public function valueIndex($value)
    {
        return array_search($value, $this->values(), true);
    }
    
    public function combineWith(Map $second)
    {
        return static::combine($this, $second);
    }
    
    public function mergeWith(Map $second)
    {
        return static::merge($this, $second);
    }
    
    public function equals(Map $second)
    {
        return static::equal($this, $second);
    }
    
    public static function combine(Map $first, Map $second)
    {
        $data = [];
        
        foreach ($first as $key => $value) {
            $data[$key] = $second[$value];
        }
        
        return new static($data);
    }
    
    public static function merge(Map $first, Map $second)
    {
        $merged = array_merge($first->all(), $second->all());
        return new static($merged);
    }
    
    public static function equal(Map $first, Map $second)
    {
        return $first->all() == $second->all();
    }
    
    public function count()
    {
        return count($this->keys());
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset)
    {
        return $this->offsetExists($offset)
                ? $this->data[$offset]
                : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function current()
    {
        return $this->data[$this->key()];
    }

    public function key()
    {
        $keys = $this->keys();
        return $keys[$this->i];
    }

    public function next()
    {
        ++$this->i;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        $keys = $this->keys();
        return isset($keys[$this->i]);
    }

    public function serialize()
    {
        return serialize($this->data);
    }

    public function unserialize($serialized)
    {
        $this->data = unserialize($serialized);
    }

    public function jsonSerialize()
    {
        return $this->data;
    }
}
