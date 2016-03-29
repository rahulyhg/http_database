<?php

require_once APPPATH.'libraries/ResourceAccess.php';

/**
 * Description of Users_model
 *
 * @author qyang
 */
class Get_model extends CI_Model {

    private $methods;

    public function __construct()
    {
        parent::__construct();
        $this->methods = [];

        $this->registerAll('all');
        $this->registerWhere('where');
        $this->registerLike('like');
        $this->registerNotLike('not_like');
    }

    private function registerAll($key) {
        $this->methods[$key] = function($method_params) {
            $table_name = $method_params[$this->getTableKey()];
            $query = $this->db->get($table_name);
            return $query->result_array();
        };
    }

    private function registerWhere($key) {
        $this->methods[$key] = function($method_params) {
            $table_name = $method_params[$this->getTableKey()];
            $query_params = $method_params[$this->getQueryParamKey()];
            $query = $this->db->where($table_name, $query_params);
            $query = $this->db->get_where($table_name, $query_params);

            return $query->result_array();
        };
    }

    private function registerLike($key) {
        $this->methods[$key] = function($method_params) {
            $table_name = $method_params[$this->getTableKey()];
            $query_params = $method_params[$this->getQueryParamKey()];

            $query = $this->db->like($query_params);
            $query = $query->get($table_name);
            return $query->result_array();
        };
    }

    private function registerNotLike($key) {
        $this->methods[$key] = function($method_params) {
            $table_name = $method_params[$this->getTableKey()];
            $query_params = $method_params[$this->getQueryParamKey()];

            $query = $this->db->not_like($query_params);
            $query = $query->get($table_name);
            return $query->result_array();
        };
    }

    public function getResource($method = 'all', $method_params = []) {
        $func = $this->methods[$method];
        return $func($method_params);
    }

    private function getTableKey() {
        return $this->config->item('table_key');
    }

    private function getQueryParamKey() {
        return $this->config->item('query_param_key');
    }
}
