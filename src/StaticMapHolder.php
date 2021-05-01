<?php
namespace Dfossacecchi\HumbleMap;

use Dfossacecchi\HumbleMap\Exceptions\NotFoundMapException;
trait StaticMapHolder
{   
    public static function __callStatic($name, $args)
    {
        return static::getMapFromMethodName($name);
    }
    
    protected static function getMapFromMethodName($name)
    {
        static $cache = [];
        
        if (false == isset(static::$maps_data) || false == is_array(static::$maps_data)) {
            throw new NotFoundMapException("map data are not initialized");
        }
        
        if (!preg_match('/^get(.+)Map$/u', $name, $matches, PREG_OFFSET_CAPTURE, 0)) {
            throw new \BadMethodCallException("$name method does not exists");
        }
        
        $map_key = from_pascal_to_snakecase($matches[1][0]);
        
        if (isset($cache[$map_key])) {
            return $cache[$map_key];
        }
        
        if (isset(static::$maps_data[$map_key]) && is_array(static::$maps_data[$map_key])) {
            $cache[$map_key] = new Map(static::$maps_data[$map_key]);
            return $cache[$map_key];
        }
        
        throw new NotFoundMapException("Map $map_key not found");
    }
}
