<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<header class="main-header"></header>
<nav class="main-nav">
    <?php if ($this->ion_auth->logged_in()) : ?>
    <ul class="nav nav-auth">
        <li>
            <a href="<?=site_url(); ?>" title="<?=$this->lang->line('site_menu_home')?>">
                <i class="fas fa-home"></i>
            </a>
        </li>
        <li>
            <a href="<?=site_url('people'); ?>">
                <?=$this->lang->line('site_menu_people')?>
            </a>
        </li>
        <li>
            <a href="<?=site_url('groups'); ?>">
                <?=$this->lang->line('site_menu_groups')?>
            </a>
        </li>
        <li>
            <div class="form-group">
                <span class="form-control"><i class="fas fa-search"></i></span>
                <input class="form-control" type="text" id="menuSearch" placeholder="<?=$this->lang->line('site_menu_groups')?> &hellip;"/>
            </div>
        </li>
        <li><i class="fas fa-bell"></i></li>
        <li><a href="<?=site_url('rules'); ?>"><?=$this->lang->line('site_menu_rules')?></a></li>
        <li><a href="#"><?=$this->lang->line('site_menu_setting')?></a></li>
        <li><a href="<?php echo site_url('auth/logout'); ?>"><?=$this->lang->line('site_menu_signOut')?></a></li>
        <li><a href="<?php echo site_url('rss'); ?>">RSS+</a></li>
    </ul>
    <?php else : ?>
    <ul class="nav nav-no-auth">
        <li><a href="/rules"><?=$this->lang->line('site_menu_rules')?></a></li>
        <li><a href="/for_investors"><?=$this->lang->line('site_menu_forInvestors')?></a></li>
        <li class="active"><a href="/auth/login"><?=$this->lang->line('site_menu_signIn')?></a></li>
    </ul>
    <?php endif; ?>
</nav>
