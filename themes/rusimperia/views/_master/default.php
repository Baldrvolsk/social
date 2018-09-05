<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="<?=(empty($lang_abbr)?'ru':$lang_abbr) ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.68, user-scalable=yes" />
	<base href="<?php echo base_url(); ?>">
	<title><?php echo Events::trigger('the_title', $title, 'string'); ?></title>
    <?=(empty($metadata)?'':$metadata)?>
    <?=(empty($icons)?'':$icons)?>

	<!-- StyleSheets -->
    <link href="//fonts.googleapis.com/css?family=PT+Serif:400,700&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <?=(empty($css_files)?'':$css_files)?>
    <link rel="stylesheet"
          href="//use.fontawesome.com/releases/v5.2.0/css/all.css"
          integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
          crossorigin="anonymous">
</head>
<body>
    <!--[if lte IE 9]>
        <p class="browser-upgrade">You are using an <strong>outdated</strong> browser. Please <a
                href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
	
	<?php echo @$layout; ?>

	<!-- JavaScripts -->
    <?=(empty($js_files)?'':$js_files)?>
    <?php if (false && config_item('ga_enabled') && (! empty(config_item('ga_siteid')) && config_item('ga_siteid') <> 'UA-XXXXX-Y')): ?>
        <!-- Google Analytics-->
        <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','<?php echo config_item('ga_siteid'); ?>','auto');ga('send','pageview')
        </script>
        <script src="https://www.google-analytics.com/analytics.js" async defer></script>
    <?php endif; ?>
</body>
</html>
