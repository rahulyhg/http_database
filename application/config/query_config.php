<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Order of precedence
 * The order of methods by precedence, a smaller array index is checked before a larger array index.
 * 'all' should always remain at the end to be used as a fallback.
 * 'all' does not need to be a http parameter from the url.
 */
$get_methods = [];

$get_methods['where'] = ['method' => 'where', 'possible_conditional' => true];
$get_methods['like'] = ['method' => 'like', 'possible_conditional' => false];
$get_methods['not_like'] = ['method' => 'not_like', 'possible_conditional' => false];
$get_methods['all'] = ['method' => 'all', 'possible_conditional' => false];

$config['get_methods'] = $get_methods;

$config['table_key'] = 'table';
$config['query_param_key'] = 'query_params';

