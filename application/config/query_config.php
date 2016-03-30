<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Order of precedence
 * The order of methods by precedence, a smaller array index is checked before a larger array index.
 * 'all' should always remain at the end to be used as a fallback.
 * 'all' does not need to be a http parameter from the url.
 */

//THE ORDER MATTERS!
//possible_conditional => true means the parameters from the url can have comparisons operators like =, !=, >, >=, <, <!
$level_one_queries['where'] = ['method' => 'where', 'possible_conditional' => true];
$level_one_queries['or_where'] = ['method' => 'or_where', 'possible_conditional' => true];
$level_one_queries['like'] = ['method' => 'like', 'possible_conditional' => false];
$level_one_queries['not_like'] = ['method' => 'not_like', 'possible_conditional' => false];
$level_one_queries['all'] = ['method' => 'all', 'possible_conditional' => false];

//THE ORDER MATTERS!
//possible_csv => true means the parameters from the url can be comma separated, eg select="v1,v2,v3"
$level_two_queries['select'] = ['method' => 'select', 'possible_csv' => true];
$level_two_queries['max'] = ['method' => 'max', 'possible_csv' => false];
$level_two_queries['min'] = ['method' => 'min', 'possible_csv' => false];
$level_two_queries['avg'] = ['method' => 'avg', 'possible_csv' => false];
$level_two_queries['sum'] = ['method' => 'sum', 'possible_csv' => false];


$config['level_one_queries'] = $level_one_queries;
$config['level_two_queries'] = $level_two_queries;

$config['table_key'] = 'table';
$config['query_param_key'] = 'query_params';

$config['default_query_limit'] = 20;
$config['default_query_offset'] = 0;

