<?php
//$config['group_'] = ;

// стоимость создания группы
$config['group_cost'] = 10;
//время блокировки создания групп в формате DateInterval
$config['group_create_interval'] = 'P1M';
// настройки группы по умолчанию
$config['group_setting'] = array('wall' => 'open', 'albums' => 'open', 'event' => 'open');
//правила для групп
$config['group_rules'] = array(
    'edit_setting',
    'edit_rules',
    'edit_users',
    'add_users',
    'edit_admin',
    'del_users',
    'ban_users',
    'add_post',
    'edit_post',
    'del_post',
    'add_album',
    'edit_album',
    'del_album',
    'add_event',
    'edit_event',
    'del_event',
);
