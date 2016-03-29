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
        //look in application/config/query_config.php for these keys
        $table_key = $this->config->item('table_key');
        $query_param_key = $this->config->item('query_param_key');

        //no table name, just crash out
        if (!array_key_exists($table_key, $this->query())) {
            $this->response('Missing name query parameter', 500);
        }

        //look in application/config/query_config.php for this array
        $level_one_queries = $this->config->item('level_one_queries');;

        $table_name = urldecode($this->query($table_key));

        //build a result array
        $result = array($table_key => $table_name);
        $fall_back = true;

        foreach ($level_one_queries as $query) {
            if (array_key_exists($query['method'], $this->query())) {
                $x_www_form_encoded = urldecode($this->query($query['method']));
                $query_params = ResourceAccess::BuildParams($x_www_form_encoded, $query['possible_conditional']);
                $method_params = [$table_key => $table_name, $query_param_key => $query_params];
                $result['data'] = $this->Get_model->getResource($query['method'], $method_params);

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
