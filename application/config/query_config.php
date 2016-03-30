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
$level_one_queries['having'] = ['method' => 'having', 'possible_conditional' => true];
$level_one_queries['or_having'] = ['method' => 'or_having', 'possible_conditional' => true];
$level_one_queries['like'] = ['method' => 'like'];
$level_one_queries['not_like'] = ['method' => 'not_like'];
$level_one_queries['all'] = ['method' => 'all'];

//not yet implemented
$level_two_queries['where_in'] = ['method' => 'where_in', 'required_variable' => true];
$level_two_queries['or_where_in'] = ['method' => 'or_where_in', 'required_variable' => true];
$level_two_queries['where_not_in'] = ['method' => 'where_not_in', 'required_variable' => true];
$level_two_queries['or_where_not_in'] = ['method' => 'or_where_not_in', 'required_variable' => true];
$level_two_queries['or_like'] = ['method' => 'or_like', 'required_variable' => true];
$level_two_queries['or_not_like'] = ['method' => 'or_not_like', 'required_variable' => true];
$level_two_queries['join'] = ['method' => 'join', 'required_variable' => true];

//THE ORDER MATTERS!
//possible_csv => true means the parameters from the url can be comma separated, eg select="v1,v2,v3"
$level_three_queries['select'] = ['method' => 'select', 'possible_csv' => true];
$level_three_queries['max'] = ['method' => 'max'];
$level_three_queries['min'] = ['method' => 'min'];
$level_three_queries['avg'] = ['method' => 'avg'];
$level_three_queries['sum'] = ['method' => 'sum'];
$level_three_queries['group_by'] = ['method' => 'group_by', 'possible_csv' => true];
$level_three_queries['distinct'] = ['method' => 'distinct'];
$level_three_queries['order_by'] = ['method' => 'order_by', 'possible_csv' => true];
$level_three_queries['limit'] = ['method' => 'limit'];
$level_three_queries['offset'] = ['method' => 'offset'];


$config['level_one_queries'] = $level_one_queries;
$config['level_two_queries'] = $level_two_queries;
$config['level_three_queries'] = $level_three_queries;

$config['table_key'] = 'table';
$config['variable_key'] = 'var';
$config['query_param_key'] = 'query_params';

$config['default_query_limit'] = 20;
$config['default_query_offset'] = 0;

