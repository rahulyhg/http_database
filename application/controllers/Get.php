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
        $table_key = $this->config->item('table_key');
        $query_param_key = $this->config->item('query_param_key');

        //no table name, just crash out
        if (!array_key_exists($table_key, $this->query())) {
            $this->response('Missing name query parameter', 500);
        }

        /*
         * These characters need encoding
         * ! # $ ' ( ) * + ,  / : ; = ? @ [ ]
         */
        $get_methods = $this->config->item('get_methods');;

        $table_name = urldecode($this->query($table_key));
        $result = array($table_key => $table_name);
        $fall_back = true;

        foreach ($get_methods as $get) {
            if (array_key_exists($get['method'], $this->query())) {
                $x_www_form_encoded = urldecode($this->query($get['method']));
                $query_params = ResourceAccess::BuildParams($x_www_form_encoded, $get['possible_conditional']);
                $method_params = [$table_key => $table_name, $query_param_key => $query_params];
                $result['data'] = $this->Get_model->getResource($get['method'], $method_params);

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
