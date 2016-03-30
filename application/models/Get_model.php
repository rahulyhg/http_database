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
        $this->register_or_where('or_where');
        //$this->register_where_in('where_in');
        $this->register_like('like');
        $this->register_not_like('not_like');
        $this->register_select('select');
        $this->register_max('max');
        $this->register_min('min');
        $this->register_avg('avg');
        $this->register_sum('sum');
        $this->register_group_by('group_by');
        $this->register_distinct('distinct');
    }

    private function register_all($key) {
        $this->methods[$key] = function($method_params) {
            $this->db->select('*');
        };
    }

    private function register_where($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->get_query_param_key()];

            foreach ($query_params as $p => $v) {
                $this->db->where($p, $v);
            }
        };
    }

    private function register_or_where($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->get_query_param_key()];

            foreach ($query_params as $p => $v) {
                $this->db->or_where($p, $v);
            }
        };
    }

    //does not work yet
    private function register_where_in($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->get_query_param_key()];
            $variable = $method_params[$this->get_variable_key()];

            $this->db->where_in($variable, $query_params);
        };
    }

    private function register_like($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->get_query_param_key()];

            $this->db->like($query_params);
        };
    }

    private function register_not_like($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->get_query_param_key()];

            $this->db->not_like($query_params);
        };
    }

    private function register_select($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->get_query_param_key()];

            $this->db->select($query_params);
        };
    }

    private function register_max($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->get_query_param_key()];

            $this->db->select_max($query_params);
        };
    }

    private function register_min($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->get_query_param_key()];

            $this->db->select_min($query_params);
        };
    }

    private function register_avg($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->get_query_param_key()];

            $this->db->select_avg($query_params);
        };
    }

    private function register_sum($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->get_query_param_key()];

            $this->db->select_sum($query_params);
        };
    }

    private function register_group_by($key) {
        $this->methods[$key] = function($method_params) {
            $query_params = $method_params[$this->get_query_param_key()];

            $this->db->group_by($query_params);
        };
    }

    private function register_distinct($key) {
        $this->methods[$key] = function($method_params) {
            $this->db->distinct();
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

    private function get_table_key() {
        return $this->config->item('table_key');
    }

    private function get_query_param_key() {
        return $this->config->item('query_param_key');
    }

    private function get_variable_key() {
        return $this->config->item('variable_key');
    }
}
