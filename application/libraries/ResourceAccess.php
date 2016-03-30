<?php

/**
 * Created by PhpStorm.
 * User: xiaoerge
 * Date: 3/24/16
 * Time: 8:58 PM
 */
class ResourceAccess
{
    public static function BuildLV1Params($x_www_form_urlencoded, $possible_conditional) {
        $params = array();

        $x_www_form_urlencoded = str_replace('"', "", $x_www_form_urlencoded);
        $x_www_form_urlencoded = str_replace("'", "", $x_www_form_urlencoded);

        foreach (explode('&', $x_www_form_urlencoded) as $chunk) {
            $pattern = '/(!=|<=|<|>=|>|=)/';
            $param = preg_split($pattern, $chunk, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

            if ($param) {
                if ($possible_conditional) {
                    $params[urldecode($param[0]).' '.urldecode($param[1])] = urldecode($param[2]);
                }
                else {
                    $params[urldecode($param[0])] = urldecode($param[2]);
                }
            }
        }

        return $params;
    }

    public static function BuildLV2Params($x_www_form_urlencoded, $possible_csv) {
        $x_www_form_urlencoded = str_replace('"', "", $x_www_form_urlencoded);
        $x_www_form_urlencoded = str_replace("'", "", $x_www_form_urlencoded);

        return $params = $x_www_form_urlencoded;
    }

    public static function GetFromArray(&$var, $default=null) {
        return isset($var) ? $var : $default;
    }
}