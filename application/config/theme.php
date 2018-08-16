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
$config['theme']['site_keywords']    = 'rusimperia, русская империя';
