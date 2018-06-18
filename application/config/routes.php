<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|	$route['404_override'] = 'errors/page_missing';
|	$route['translate_uri_dashes'] = FALSE;
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['friends/delete/(:num)'] = 'friends/delete_friend/$1';
$route['friends/add/(:num)'] = 'friends/add_friend/$1/0';
$route['profile/(:num)'] = 'profile/index/$1';
$route['post/add/(:num)'] = 'post/add_post/$1';
$route['webhook/(:any)'] = 'webhook/deploy/$1';
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
