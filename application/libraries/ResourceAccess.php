<?php

/**
 * Created by PhpStorm.
 * User: xiaoerge
 * Date: 3/24/16
 * Time: 8:58 PM
 */
class ResourceAccess
{
    public static function BuildParams($x_www_form_urlencoded) {
        $params = array();

        $x_www_form_urlencoded = str_replace('"', "", $x_www_form_urlencoded);
        $x_www_form_urlencoded = str_replace("'", "", $x_www_form_urlencoded);

        foreach (explode('&', $x_www_form_urlencoded) as $chunk) {
            $param = explode("=", $chunk);
            if ($param) {
                $params[urldecode($param[0])] = urldecode($param[1]);
            }
        }
        return $params;
    }
}