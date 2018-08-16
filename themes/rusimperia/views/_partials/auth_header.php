<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<header class="auth-header"></header>
<nav class="auth-nav" >
	<ul class="nav">
        <li><a href="/rules"><?=$this->lang->line('site_menu_rules')?></a></li>
        <li><a href="/for_investors"><?=$this->lang->line('site_menu_forInvestors')?></a></li>
        <li class="active"><a href="/auth/login"><?=$this->lang->line('site_menu_signIn')?></a></li>
    </ul>
</nav>
