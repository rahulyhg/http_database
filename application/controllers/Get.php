<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/REST_Controller.php';
require_once APPPATH.'libraries/ResourceAccess.php';

class Get extends REST_Controller {

    /**
     * <p>
     * Get method for table access
     * <p>
     */
    public function index_get()
    {
        //no table name, just crash out
        $table_key = $this->Get_model->getTableKey();
        $query_param_key = $this->Get_model->getQueryParamKey();

        if (!array_key_exists($table_key, $this->query())) {
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
         * 'all' does not need to be a http parameter from the url.
         */
        $method_keys = [];

        $method_keys['where'] = ['method' => 'where', 'possible_conditional' => true];
        $method_keys['like'] = ['method' => 'like', 'possible_conditional' => false];
        $method_keys['not_like'] = ['method' => 'not_like', 'possible_conditional' => false];
        $method_keys['all'] = ['method' => 'all', 'possible_conditional' => false];

        $table_name = urldecode($this->query($table_key));
        $result = array($table_key => $table_name);
        $fall_back = true;

        foreach ($method_keys as $method) {
            if (array_key_exists($method['method'], $this->query())) {
                $x_www_form_encoded = urldecode($this->query($method['method']));
                $query_params = ResourceAccess::BuildParams($x_www_form_encoded, $method['possible_conditional']);
                $method_params = [$table_key => $table_name, $query_param_key => $query_params];
                $result['data'] = $this->Get_model->getResource($method['method'], $method_params);

                $fall_back = false;
                break;
            }
        }

        if ($fall_back) {
            $result['data'] = $this->Get_model->getResource('all', $method_params = [$table_key => $table_name, $query_param_key => []]);
        }

        $this->response($result);
    }
}
