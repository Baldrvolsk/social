<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Theme Library Configuration
 *
 * This files holds theme settings
 *
 * @package 	CodeIgniter
 * @category 	Configuration
 */

/*
| -------------------------------------------------------------------
| Theme Settings
| -------------------------------------------------------------------
|
|  'theme.theme' 			the activated site theme.
|  'theme.master' 			theme default master view file.
|  'theme.layout' 			theme default layout file.
|  'theme.title_sep' 		string to be used as title separator.
|  'theme.compress' 		whether to compress HTML output to not.
|  'theme.cache_lifetime' 	whether to cache output or not.
|
| CDN settings:
|	'theme.cdn_enabled'		If true, the 2nd param of css(), js() is used.
|	'theme.cdn_server'		If your host your assets on a CDN, privide URL.
*/

// Site default theme
$config['theme']['theme'] = 'rusimperia';

// Site default master view file.
$config['theme']['master'] = 'default';

// Site default layout file
$config['theme']['layout'] = 'default';

// Site title separator
$config['theme']['title_sep'] = '&#150;';

// Minify HTML Output
//$config['theme']['compress'] = (defined('ENVIRONMENT') && ENVIRONMENT == 'production');
$config['theme']['compress'] = false;

// Cache life time
$config['theme']['cache_lifetime'] = 0;

// Enable CDN (to use 2nd argument of css() & js() functions)
//$config['theme']['cdn_enabled'] = (defined('ENVIRONMENT') && ENVIRONMENT == 'production');
$config['theme']['cdn_enabled'] = false;

// The CDN URL if you host your files there
$config['theme']['cdn_server'] = ''; // i.e: 'http://static.myhost.com/';

// ------------------------------------------------------------------------
// Backup plan :D for site name, desription & keywords
// ------------------------------------------------------------------------

// Default site name, description and keywords.
$config['theme']['site_name']        = 'RusImperia';
$config['theme']['site_description'] = 'RusImperia социальная сеть.';
$config['theme']['site_keywords']    = 'Русская, Русский, Империя, Российский, Самодержавный, Самодержавие, '
    .'Самодержец, Император, Имперский, Мы – Русские, Россия, Русь, Страна , Народ, Государство, Православие, '
    .'Народность, Российская, Москва, Санкт-петербург, Екатеринбург, Нижний новогород, Тверь, Владимир, Рязань, '
    .'Томск, Омск, Новосибирск, Тюмень, Ревель, Симбирск, Самара, Вологда, Ярославль, Псков, Смоленск, Киев, Минск, '
    .'Брянск, Ставрополь, Екатеринодар, Ростов, Калуга, Рязань, Новгород, Великий новгород, Астрахань, Курган, '
    .'Вятка, Смоленск, Европейская, Сибирь, Дальний восток, Государственность, Царь, Царский, Царственный, '
    .'Монархия, Монархизм, Монархист, Монархический, Столица, Столичный, Православный, Государственнообразующий, '
    .'Народ, Коренной, России – Русскую власть, Власть, Властелин, Властитель, Общение, Новая, Социальная, Сеть, '
    .'Социальная сеть, Православная социальная сеть, Монархическая социальная сеть, Соц. Сеть, Без цензуры, '
    .'Свобода, Консерватизм, Правые, Правый, Против красных, Белые, Белый, Антибольшевики, Антибольшевизм, '
    .'Антикоммунизм, Декоммунизация, Русская империя, Контрреволюция, Белое движение, Белогвардеец, Белогвардейцы, '
    .'Белая гвардия, Мы – контрреволюция, Конец оккупации, Свобода русской нации, Государственный, Флаг, Герб, '
    .'Гимн, Новомученики, Исповедники, Земля Российская, Николай, Александр, Павел, Петр, Михаил Федорович, '
    .'Романов, Романовы, Анастасия, Алексий, Цесаревич, Царевич, Царевна, Царица, Александра Федоровна, '
    .'Николай Александрович, Граф, Князь, Боярин, Мещанин, История, Исторический, Крестьянин, Помещик, 1917, '
    .'1612, Церковь, РПЦ';
