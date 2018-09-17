<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-box">
    <ul class="sub-nav">
        <li>Все пользователи</li>
        <li>Пользователи онлайн</li>
    </ul>
    <div class="search">
        <div class="search-panel">
            <span class="fas fa-search search-icon fa-lg"></span>
            <input class="search-input" type="text" id="menuSearch" placeholder="<?=$this->lang->line('site_menu_search')?>"/>
            <span class="fas fa-sliders-h search-filter fa-lg"></span>
        </div>
        <div class="search-filter"></div>
    </div>
    <ul class="content-list">
    <?php foreach ($people as $row): ?>
        <li class="content-item people-item">
            <div class="item-photo">
                <img src="/media/user/avatar/<?=$row->avatar?>" class="item-img">
            </div>
            <a class="item-link" href="/profile/<?=$row->id?>" title="Посмотреть профиль">
                <?php if ($row->online) : ?>
                <i class="fas fa-circle fa-xs item-online"></i>
                <?php endif; ?>
                <span><?=$row->full_name_user?></span>
            </a>
            <div class="item-rang">
                <?php
                if ($row->group_id > 40) $row->group_id = 40;
                $rangName = $this->lang->line('profile_rang_name_'.$row->group_id);
                switch ((int)$row->group_id) {
                    case 10:
                        $rangIcon = 'far fa-smile';
                        break;
                    case 20:
                        $rangIcon = 'far fa-user';
                        break;
                    case 30:
                        $rangIcon = 'fas fa-university';
                        break;
                    case 40:
                        $rangIcon = 'fas fa-crown';
                        break;
                }
                ?>
                <i class="<?=$rangIcon?> item-rang-icon"></i> <?=$rangName?>
            </div>
            <div class="item-button">
            <?php if (!empty($row->u_f_status)) : // если просматривающий страницу добавлял в друзья
                switch ($row->u_f_status) {
                    case 'request': ?>
                        <a href="/friends/delete/<?=$row->id?>" class="btn btn-info" title="Вы уже
            отправили запрос на добавление в друзья">
                            Удалить запрос
                        </a>
                        <?php break;
                    case 'confirmed': ?>
                        <a href="/friends/delete/<?=$row->id?>" class="btn btn-info">
                            Удалить из друзей
                        </a>
                        <?php break;
                    case 'blacklist': ?>
                        <a href="/friends/delete/<?=$row->id?>" class="btn btn-info">
                            Удалить из черного списка
                        </a>
                    <?php }
            elseif (!empty($row->f_u_status)) : // если выводимый пользователь добавлял в друзья
                switch ($row->f_u_status) {
                    case 'request': ?>
                        <a href="/friends/confirm_friend/<?=$row->id?>" class="btn btn-info">
                            Подтвердить запрос в друзья
                        </a>
                        <?php break;
                    case 'confirmed': ?>
                        <a href="/friends/delete/<?=$row->id?>" class="btn btn-info">
                            Удалить из друзей
                        </a>
                        <?php break;
                    case 'blacklist': ?>
                        <a href="/friends/add/<?=$row->id?>" class="btn btn-info">
                            Добавить в друзья
                        </a>
                    <?php }
            else : ?>
                <button type="button" class="btn tooltip" onclick="addFriends(<?=$row->id?>)">
                    <i class="fas fa-user-plus"></i>
                    <span class="tooltip-content">
                        <span class="tooltip-text">
                            <span class="tooltip-inner">Добавить в друзья</span>
                        </span>
					</span>
                </button>
            <?php endif; ?>
            </div>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
<!--
<i class="fas fa-user-minus"></i>

-->