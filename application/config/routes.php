<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// профиль пользователя
$route['profile/(:num)'] = 'profile/index/$1';
// группы
$route['groups'] = 'group/index';
$route['group/(:num)'] = 'group/view/$1';
$route['my_group'] = 'group/my_group';
// друзья
$route['friends/delete/(:num)'] = 'friend/delete_friend/$1';
$route['friends/add/(:num)'] = 'friend/add_friend/$1/0';
// вебхук
$route['webhook/(:any)'] = 'webhook/deploy/$1';
// статические страницы
$route['rules'] = 'page/index/rules';
// default route
$route['default_controller'] = 'by_default';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
