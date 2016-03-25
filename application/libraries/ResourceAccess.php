<?php

/**
 * Created by PhpStorm.
 * User: xiaoerge
 * Date: 3/24/16
 * Time: 8:58 PM
 */
class ResourceAccess
{
    public static function Equals() {

        $ci =& get_instance();
        $ci->load->model('Table_model');

        return 'foo';
    }
}