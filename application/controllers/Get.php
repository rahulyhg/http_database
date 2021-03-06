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
        $variable = $this->config->item('variable_key');
        $join_type = $this->config->item('join_type_key');

        //no table name, just crash out
        if (!array_key_exists($table_key, $this->query())) {
            $this->response('Missing name query parameter', 500);
        }
        $table_name = urldecode($this->query($table_key));

        //look in application/config/query_config.php for these arrays
        $level_one_queries = $this->config->item('level_one_queries');
        $level_two_queries = $this->config->item('level_two_queries');
        $level_three_queries = $this->config->item('level_three_queries');

        foreach ($level_one_queries as $lv1) {
            if (array_key_exists($lv1['method'], $this->query())) {

                $x_www_form_encoded = urldecode($this->query($lv1['method']));
                $query_params = ResourceAccess::BuildLV1Params($x_www_form_encoded,
                    ResourceAccess::GetFromArray($lv1['possible_conditional'], false));

                $method_params = [$table_key => $table_name, $query_param_key => $query_params];
                $this->Get_model->chain_query($lv1['method'], $method_params);
            }
        }

        foreach ($level_two_queries as $lv2) {
            if (array_key_exists($lv2['method'], $this->query())) {

                $x_www_form_encoded = urldecode($this->query($lv2['method']));
                $query_params = ResourceAccess::BuildLV2Params($x_www_form_encoded,
                    ResourceAccess::GetFromArray($lv2['required_variable'], false));

                $method_params = [$table_key => $table_name, $query_param_key => $query_params,
                    $variable => $this->query($variable), $join_type => $this->query($join_type)];
                $this->Get_model->chain_query($lv2['method'], $method_params);
            }
        }

        foreach ($level_three_queries as $lv3) {
            if (array_key_exists($lv3['method'], $this->query())) {

                $x_www_form_encoded = urldecode($this->query($lv3['method']));
                $query_params = ResourceAccess::BuildLV3Params($x_www_form_encoded,
                    ResourceAccess::GetFromArray($lv3['possible_csv'], false));

                $method_params = [$table_key => $table_name, $query_param_key => $query_params];
                $this->Get_model->chain_query($lv3['method'], $method_params);
            }
        }

        $data = $this->Get_model->result_array($table_name);

        //build a result array
        $result[$table_key] = $table_name;
        $result['query'] = $this->Get_model->last_query();
        $result['data'] = $data;

        $this->response($result);
    }
}
