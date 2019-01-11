<?php

namespace Trollweb;

class ValidationHelper
{
    /**
     * Checks if the url is valid or not
     *
     * @param string $url
     * @return boolean
     */
    public function url($url)
    {
        // Remove all illegal characters from a url
        $string_helper = new StringHelper();
        $url = $string_helper->remove_accented_chars($url);

        if (strpos($url, 'http') === false && strpos($url, '.') !== false)
        {
            $url = 'http://' . $url;
        }

        return filter_var($url, FILTER_VALIDATE_URL) === false ? false : true;
    }

    /**
     * Checks if the email is valid or not
     *
     * @param string $email
     * @return boolean
     */
    public function email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) === false ? false : true;
    }

    /**
     * Checks if the IP address is valid or not
     *
     * @param string $ip
     * @return boolean
     */
    public function ip($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false ? false : true;
    }

    /**
     * Validates contents based on rules
     *
     * @param mixed $content
     * @param mixed $rules
     * @return boolean
     */
    public function validate($content, $rules)
    {
        foreach ($rules as $key => $value) 
        {
            if ($key == 'min')
            {
                if (gettype($content) == 'string')
                {
                    if (strlen($content) < $value)
                    {
                        return false;
                    }
                }
                else
                {
                    if ($content < $value)
                    {
                        return false;
                    }
                }
            }
            else if ($key == 'max')
            {
                if (gettype($content) == 'string')
                {
                    if (strlen($content) > $value)
                    {
                        return false;
                    }
                }
                else
                {
                    if ($content > $value)
                    {
                        return false;
                    }
                }
            }
            else if ($key == 'type')
            {
                $value = str_replace('bool', 'boolean', $value);
                $value = str_replace('float', 'double', $value);
                $types = explode('|', $value);

                if (!in_array(gettype($content), $types))
                {
                    return false;
                }
                
            }
            else if ($key == 'contains')
            {
                if (strpos($content, $value) === false)
                {
                    return false;
                }
            }
        }

        return true;
    }
    
}
