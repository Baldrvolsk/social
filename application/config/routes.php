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

$route['group/(:num)'] = 'group/view_group/$1';
$route['my_group'] = 'group/my_group';
$route['groups'] = 'group/index';
$route['friends/delete/(:num)'] = 'friend/delete_friend/$1';
$route['friends/add/(:num)'] = 'friend/add_friend/$1/0';
$route['profile/(:num)'] = 'profile/index/$1';
$route['webhook/(:any)'] = 'webhook/deploy/$1';

// static pages
$route['rules'] = 'page/index/rules';
$route['privacy'] = 'page/index/privacy';
// default route
$route['default_controller'] = 'by_default';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
