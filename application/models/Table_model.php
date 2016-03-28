<?php

require_once APPPATH.'libraries/ResourceAccess.php';

/**
 * Description of Users_model
 *
 * @author qyang
 */
class Table_model extends CI_Model {

    private $methods;

    public function __construct()
    {
        parent::__construct();
        $this->methods = [];

        $this->registerAll();
        $this->registerWhere();
        $this->registerLike();
    }

    private function registerAll() {
        $this->methods['all'] = function($method_params) {
            $table_name = $method_params['name'];
            $query = $this->db->get($table_name);
            return $query->result_array();
        };
    }

    private function registerWhere() {
        $this->methods['where'] = function($method_params) {
            $table_name = $method_params['name'];
            $query_params = $method_params['query_params'];
            $query = $this->db->get_where($table_name, $query_params);

            return $query->result_array();
        };
    }

    private function registerLike() {
        $this->methods['like'] = function($method_params) {
            $table_name = $method_params['name'];
            $query_params = $method_params['query_params'];

            $query = $this->db->like($query_params);
            $query = $query->get($table_name);
            return $query->result_array();
        };
    }

    public function getResource($method = 'all', $method_params = []) {
        $func = $this->methods[$method];
        return $func($method_params);
    }
}
