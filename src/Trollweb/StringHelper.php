<?php

namespace Trollweb;

class StringHelper
{
    /**
     * Converts a string into Camel Case
     *
     * @param string $string
     * @return string
     */
    public function camelCase($string)
    {
        $keys = array();
    
        // Splits the `key` string with dot (.) or slash (/) separator
        $token = strtok($string, " ._");

        while ($token !== false) 
        {
            $keys[] = $token;
            $token = strtok(" ._");
        }

        $str = '';

        foreach ($keys as $key => $value) 
        {
            if ($value == strtoupper($value))
            {
                $value = strtolower($value);
            }
            
            $str .= ucfirst($value);
        }

        $str = lcfirst($str);

        return $str;
    }

    /**
     * Converts a string into Snake Case
     *
     * @param string $string
     * @return string
     */
    public function snakeCase($string)
    {
        preg_match_all('([A-Z][a-z]+|[A-Za-z]+)', $string, $matches);

        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }

    /**
     * Converts a string into URL Slug
     *
     * @param string $string
     * @return string
     */
    public function urlSlug($string)
    {
        // Replace accented characters with normal equivalent
        $string = $this->remove_accented_chars($string);

        // Convert the string to lowercase
        $string = strtolower($string);

        // Replace spaces ` ` with dashes `-`
        $string = str_replace(' ', '-', $string);

        return $string;
    }

    /**
     * Removes accented foreign characters
     *
     * @param string $str
     * @return string
     */
    public function remove_accented_chars($str)
    {
        $unwanted_array = array(
                            'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A','Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' 
                        );
        return strtr($str, $unwanted_array);
    }
}
