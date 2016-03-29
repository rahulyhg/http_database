<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['table_key'] = 'table';
$config['query_param_key'] = 'query_params';

/*
 * Order of precedence
 * The order of methods by precedence, a smaller array index is checked before a larger array index.
 * 'all' should always remain at the end to be used as a fallback.
 * 'all' does not need to be a http parameter from the url.
 */
$level_one_queries = [];

//THIS ORDER MATTERS!
//possible_conditional => true means the parameters from the url can have comparisons operators like =, !=, >, >=, <, <!
//possible_csv => true means the parameters from the url can be comma separated like v1,v2,v3
$level_one_queries['where'] = ['method' => 'where', 'possible_conditional' => true];
$level_one_queries['like'] = ['method' => 'like', 'possible_conditional' => false];
$level_one_queries['not_like'] = ['method' => 'not_like', 'possible_conditional' => false];
$level_one_queries['all'] = ['method' => 'all', 'possible_conditional' => false];

$config['level_one_queries'] = $level_one_queries;

$level_two_methods['select'] = ['method' => 'select', 'possible_conditional' => false, 'possible_csv' => true];



