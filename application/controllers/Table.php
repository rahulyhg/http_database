<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/REST_Controller.php';
require_once APPPATH.'libraries/ResourceAccess.php';

class Table extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Table_model');
    }

    //! # $ ' ( ) * + ,  / : ; = ? @ [ ]
    public function index_get()
    {
        //no table name, crash out
        if (!array_key_exists('name', $this->query())) {
            $this->response('Missing name query parameter', 500);
        }

        $table_name = urldecode($this->query('name'));
        $result = array('name' => $table_name);

        //equal clause
        if (array_key_exists('equal', $this->query())) {

            $where = urldecode($this->query('equal'));
            $where = str_replace('"', "", $where);
            $where = str_replace("'", "", $where);
            $w_param = array();

            foreach (explode('&', $where) as $chunk) {
                $param = explode("=", $chunk);
                if ($param) {
                    $w_param[urldecode($param[0])] = urldecode($param[1]);
                }
            }

            $result['data'] = $this->Table_model->where($table_name, $w_param);
        }
        else {
            //$result['data'] = $this->Table_model->all($table_name);
            $result['data'] = ResourceAccess::Equals();
        }

        $this->response($result);
    }
}
