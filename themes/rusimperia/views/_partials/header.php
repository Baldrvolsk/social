<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<header class="main-header"></header>
<nav class="main-nav<?=(($this->ion_auth->logged_in())?' nav-auth':' nav-no-auth')?>">
    <?php if ($this->ion_auth->logged_in()) : ?>
    <ul class="nav nav-left">
        <li<?=(($this->uri->segment(1) === 'profile')?' class="active"':'')?>>
            <a href="<?=site_url(); ?>" title="<?=$this->lang->line('site_menu_home')?>">
                <i class="fas fa-home"></i>
            </a>
        </li>
        <li<?=(($this->uri->segment(1) === 'people')?' class="active"':'')?>>
            <a href="<?=site_url('people'); ?>">
                <?=$this->lang->line('site_menu_people')?>
            </a>
        </li>
        <li<?=(($this->uri->segment(1) === 'groups')?' class="active"':'')?>>
            <a href="<?=site_url('groups'); ?>">
                <?=$this->lang->line('site_menu_groups')?>
            </a>
        </li>
        <li>
            <div class="search-panel">
                <span class="fas fa-search search-icon fa-lg"></span>
                <input class="search-input" type="text" id="menuSearch" placeholder="<?=$this->lang->line('site_menu_search')?> &hellip;"/>
            </div>
        </li>
        <li>
            <i class="fas fa-bell"></i>
        </li>
    </ul>
    <ul class="nav nav-right">
        <li <?=(($this->uri->segment(1) === 'rules')?' class="active"':'')?>">
            <a href="<?=site_url('rules'); ?>"><?=$this->lang->line('site_menu_rules')?></a>
        </li>
        <li>
            <a href="#"><?=$this->lang->line('site_menu_setting')?></a>
        </li>
        <li>
            <a href="<?php echo site_url('auth/logout'); ?>"><?=$this->lang->line('site_menu_signOut')?></a>
        </li>
        <li<?=(($this->uri->segment(1) === 'rss')?' class="active"':'')?>">
            <a href="<?php echo site_url('rss'); ?>">RSS+</a>
        </li>
    </ul>
    <?php else : ?>
    <div class="nav nav-left"></div>
    <ul class="nav nav-right">
        <li<?=(($this->uri->segment(1) === 'rules')?' class="active"':'')?>>
            <a href="/rules"><?=$this->lang->line('site_menu_rules')?></a>
        </li>
        <li<?=(($this->uri->segment(1) === null)?' class="active"':'')?>>
            <a href="/"><?=$this->lang->line('site_menu_signIn')?></a>
        </li>
    </ul>
    <?php endif; ?>
</nav>
