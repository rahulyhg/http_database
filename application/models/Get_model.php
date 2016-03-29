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

        $this->register_all('all');
        $this->register_where('where');
        $this->register_like('like');
        $this->register_not_like('not_like');
        $this->register_select('select');
        $this->register_max('max');
    }

    private function register_all($key) {
        $this->methods[$key] = function($method_params) {
            $this->db->select('*');
        };
    }

    private function register_where($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->getQueryParamKey()];

            foreach ($query_params as $p => $v) {
                $this->db->where($p, $v);
            }
        };
    }

    private function register_like($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->getQueryParamKey()];

            $this->db->like($query_params);
        };
    }

    private function register_not_like($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->getQueryParamKey()];

            $this->db->not_like($query_params);
        };
    }

    private function register_select($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->getQueryParamKey()];

            $this->db->select($query_params);
        };
    }

    private function register_max($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->getQueryParamKey()];

            $this->db->select_max($query_params);
        };
    }

    public function result_array($table_name) {

        $limit = $this->config->item('default_query_limit');
        $offset = $this->config->item('default_query_offset');

        $query = $this->db->get($table_name, $limit, $offset);
        return $query->result_array();
    }

    public function last_query() {
        return $this->db->last_query();
    }

    public function chain_query($method = 'all', $method_params = []) {
        $func = $this->methods[$method];
        $func($method_params);
    }

    private function getTableKey() {
        return $this->config->item('table_key');
    }

    private function getQueryParamKey() {
        return $this->config->item('query_param_key');
    }
}
