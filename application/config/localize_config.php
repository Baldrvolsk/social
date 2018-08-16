<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Настройки локализации сайта.
 *
 *     default_key => язык сайта по умолчанию
 *     list        => список доступных языков
 *
 */
$config['ROUTE_LOCALIZE'] = array(
    'default_key' => 0, // Язык по-умолчанию, указывается ключ из массива "list"
    'list'        => array('ru', 'en'), // Доступные языки для сайта
);