<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/REST_Controller.php';
require_once APPPATH.'libraries/ResourceAccess.php';

class Table extends REST_Controller {

    /**
     * <p>
     * Get method for table access
     * <p>
     */
    public function index_get()
    {
        //no table name, just crash out
        if (!array_key_exists('name', $this->query())) {
            $this->response('Missing name query parameter', 500);
        }

        /*
         * These characters need encoding
         * ! # $ ' ( ) * + ,  / : ; = ? @ [ ]
         */

        /*
         * Order of precedence
         * The order of methods by precedence, a smaller array index is checked before a larger array index.
         * 'all' should always remain at the end to be used as a fallback.
         */
        $method_strings = ['where', 'like', 'all'];

        $table_name = urldecode($this->query('name'));
        $result = array('name' => $table_name);
        $fall_back = true;

        foreach ($method_strings as $method) {
            if (array_key_exists($method, $this->query())) {
                $x_www_form_encoded = urldecode($this->query($method));
                $query_params = ResourceAccess::BuildParams($x_www_form_encoded);
                $method_params = ['name' => $table_name, 'query_params' => $query_params];
                $result['data'] = $this->Table_model->getResource($method, $method_params);

                $fall_back = false;
                break;
            }
        }

        if ($fall_back) {
            $result['data'] = $this->Table_model->getResource('all', $method_params = ['name' => $table_name, 'query_params' => []]);
        }

        $this->response($result);
    }
}
