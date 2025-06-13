<?php

namespace App\Cores;

/**
 * Core class is a core of this system and parent of any class.
 */

class EnumCore
{
    private static $constants = NULL;
    private static $methods = NULL;

    /**
     * Get enums
     * 
     * @return mixed
     */
    private static function getEnums()
    {
        if (self::$constants == NULL) {
            self::$constants = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constants)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constants[$calledClass] = $reflect->getConstants();
        }
        return self::$constants[$calledClass];
    }

    /**
     * Get all methods from class
     * 
     * @return mixed
     */
    private static function getMethods()
    {
        $calledClass = get_called_class();
        if (self::$methods == NULL) {
            self::$methods[$calledClass] = [];
        }
        if (empty(self::$methods[$calledClass])) {
            $reflect = new \ReflectionClass($calledClass);
            foreach ($reflect->getMethods() as $method) {
                if ($method->class == $calledClass) self::$methods[$calledClass][] = $method->name;
            }
        }

        return self::$methods[$calledClass];
    }

    /**
     * Check if given name exists in enum
     * 
     * @param string
     * @param bool
     * @return bool
     */
    public static function isValidName(string $name, bool $strict = false)
    {
        $enums = self::getEnums();
        if ($strict) return array_key_exists($name, $enums);
        $keys = array_map('strtolower', array_keys($enums));
        return in_array(strtolower($name), $keys);
    }

    /**
     * Check if given value exists in enum
     * 
     * @param mixed
     * @return bool
     */
    public static function isValidValue($value)
    {
        $values = array_values(self::getEnums());
        return in_array($value, $values, $strict = true);
    }

    /**
     * Get value based on given name
     * 
     * Return false is not exists
     * 
     * @param string
     * @return mixed
     */
    public static function fromName(string $name)
    {
        $enums = self::getEnums();
        if (self::isValidName($name)) return $enums[$name];
        return false;
    }

    /**
     * Get name based on given value
     * 
     * Return false is not exists
     * 
     * If enum has non-unqiue values then the first instance is returned
     *
     * @param mixed
     * @return mixed
     */
    public static function fromValue($value)
    {
        $enums = self::getEnums();
        $enumValues = array_flip($enums);
        if (self::isValidValue($value)) return $enumValues[$value];
        return false;
    }

    /**
     * Get array of values
     * 
     * @return array
     */
    public static function getValues()
    {
        return array_values(self::getEnums());
    }

    /**
     * Return enums as array of object
     * 
     * @return array
     */
    public static function toObject()
    {
        $enums = [];
        foreach (self::getEnums() as $key => $value) {
            $enums[$key] = (object) [
                "name" => $key,
                "value" => $value
            ];
            if (count(self::getMethods()) > 0) {
                foreach (self::getMethods() as $method) {
                    $enums[$key]->$method = static::$method($value);
                }
            }
        }
        return $enums;
    }

    /**
     * Return enums as array of array
     * 
     * @return array
     */
    public static function toArray()
    {
        $enums = [];
        foreach (self::getEnums() as $key => $value) {
            $enums[$value] = [
                "name" => $key,
                "value" => $value
            ];
            if (count(self::getMethods()) > 0) {
                foreach (self::getMethods() as $method) {
                    $enums[$value][$method] = static::$method($value);
                }
            }
        }
        return $enums;
    }
}
