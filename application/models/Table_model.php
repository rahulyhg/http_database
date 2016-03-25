<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users_model
 *
 * @author qyang
 */
class Table_model extends CI_Model {
    //put your code here
    public function all($table_name = '') {
        $query = $this->db->get($table_name);
        return $query->result_array();
    }

    public function where($table_name = '', $w_params = []) {
        $query = $this->db->get_where($table_name, $w_params);
        return $query->result_array();
    }
}
