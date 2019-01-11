<?php

namespace Trollweb;

class ArrayHelper
{
    /**
     * Flatten a multidimentional array
     *
     * @param mixed $array
     * @return mixed
     */
    public function flatten($array)
    {
        return $this->prefixKey('', $array);
    }

    /**
     * Get value from a multidimentional array
     * Using dot notation or slash separator
     *
     * @param mixed $array
     * @param string $key
     * @param mixed $fallback
     * @return mixed
     */
    function get($array, $key, $fallback = null)
    {
        // Array to store `key` after spliting with separators
        $keys = array();

        // Splits the `key` string with dot (.) or slash (/) separator
        $token = strtok($key, "./");

        while ($token !== false) 
        {
            $keys[] = $token;
            $token = strtok("./");
        }

        // Iterates through the `keys` array
        for ($i = 0; $i < count($keys); $i++) 
        {
            // Creates an array with the keys of `array`
            $a = array_keys($array);

            // Gets the position of 
            $pos = array_search($keys[$i], $a);
            
            if ($pos !== false)
            {
                if ($i == count($keys) - 1)
                {
                    return $array[$a[$pos]];
                }

                $array = $array[$a[$pos]];
            }
            else 
            {
                return $fallback;
            }
        }

    }

    /**
     * Remove item from multidimentional array by key
     *
     * @param mixed $array
     * @param string $key
     * @return mixed
     */
    public function removeKey($array, $key)
    {
        // Array to store `key` after spliting with separators
        $keys = array();

        // Splits the `key` string with dot (.) or slash (/) separator
        $token = strtok($key, "./");

        while ($token !== false) 
        {
            $keys[] = $token;
            $token = strtok("./");
        }

        $this->recursiveKeyRemoval($array, $keys);


        return $array;
    }

    /**
     * Remove item from multidimentional array by value
     *
     * @param mixed $array
     * @param string $value
     * @return mixed
     */
    public function removeValue($array, $value)
    {
        $this->recursiveValueRemoval($array, $value);

        return $array;
    }

    /**
     * Helper method to flatten array
     *
     * @param string $prefix
     * @param mixed $array
     * @return mixed
     */
    public function prefixKey($prefix, $array)
    {
        $result = array();
        foreach ($array as $key => $value)
        {
            if (is_array($value))
                $result = array_merge($result, $this->prefixKey($prefix . $key . '.', $value));
            else
                $result[$prefix . $key] = $value;
        }   
        return $result;
    }

    /**
     * Helper method to remove item by value
     *
     * @param mixed $array
     * @param string $val
     * @return mixed
     */
    public function recursiveValueRemoval(&$array, $val)
    {
        if (is_array($array))
        {
            foreach ($array as $key => &$arrayElement)
            {
                if (is_array($arrayElement))
                {
                    $this->recursiveValueRemoval($arrayElement, $val);
                }
                else
                {
                    if ($arrayElement == $val)
                    {
                        unset($array[$key]);
                    }
                }
            }
        }
    }
    
    /**
     * Helper method to remove item by key
     *
     * @param mixed $array
     * @param string $val
     * @return mixed
     */
    public function recursiveKeyRemoval(&$array, $keys, $index = 0)
    {
        if (is_array($array))
        {
            foreach ($array as $key => &$arrayElement)
            {
                if ($key == $keys[$index])
                {
                    if ($index == count($keys) - 1)
                    {
                        unset($array[$key]);
                    }
                    else 
                    {
                        $this->recursiveKeyRemoval($arrayElement, $keys, ++$index);
                    }
                }
            }
        }
    }
}
