<?php
//$config['group_'] = ;

// стоимость создания группы
$config['group_need_pay_to_create'] = true;
// стоимость создания группы
$config['group_pay'] = '10';
// стоимость создания группы
$config['group_transfer_pay'] = '10';
//время блокировки создания групп в формате DateInterval
$config['group_create_interval'] = 'P1M';
//время до удаления группы в формате DateInterval
$config['group_del_time'] = 'P14D';
// настройки группы по умолчанию
$config['group_setting'] = array('wall' => 'open', 'albums' => 'open', 'event' => 'open');
//правила для групп
$config['group_rules'] = array(
    1  => array(
        'type'  => 'edit_rules',
        'title' => 'Редактирование разрешений',
        'o'      => true,
        'a'      => true,
        'e'      => false,
        'm'      => false,
        'u'      => false
    ),
    2  => array(
        'type'  => 'edit_setting',
        'title' => 'Редактирование настроек группы',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => false,
        'u'      => false
    ),
    3  => array(
        'type'  => 'add_users',
        'title' => 'Добавление пользователей',
        'o'      => true,
        'a'      => true,
        'e'      => false,
        'm'      => false,
        'u'      => false
    ),
    4  => array(
        'type'  => 'edit_users',
        'title' => 'Редактирование пользователей',
        'o'      => true,
        'a'      => true,
        'e'      => false,
        'm'      => false,
        'u'      => false
    ),
    5  => array(
        'type'  => 'edit_admin',
        'title' => 'Редактирование администрации группы',
        'o'      => true,
        'a'      => false,
        'e'      => false,
        'm'      => false,
        'u'      => false
    ),
    6  => array(
        'type'  => 'del_users',
        'title' => 'Удаление пользователей',
        'o'      => true,
        'a'      => true,
        'e'      => false,
        'm'      => true,
        'u'      => false
    ),
    7  => array(
        'type'  => 'ban_users',
        'title' => 'Блокировка пользователей',
        'o'      => true,
        'a'      => true,
        'e'      => false,
        'm'      => true,
        'u'      => false
    ),
    8  => array(
        'type'  => 'add_post',
        'title' => 'Добавление постов',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => false,
        'u'      => false
    ),
    9  => array(
        'type'  => 'edit_post',
        'title' => 'Редактирование постов',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => false,
        'u'      => false
    ),
    'u' => array(
        'type'  => 'del_post',
        'title' => 'Удаление постов',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => true,
        'u'      => false
    ),
    11 => array(
        'type'  => 'add_album',
        'title' => 'Создание альбомов',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => false,
        'u'      => false
    ),
    12 => array(
        'type'  => 'edit_album',
        'title' => 'Редактирование альбомов',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => true,
        'u'      => false
    ),
    13 => array(
        'type'  => 'del_album',
        'title' => 'Удаление альбомов',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => true,
        'u'      => false
    ),
    14 => array(
        'type'  => 'add_event',
        'title' => 'Создание мероприятий',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => false,
        'u'      => false
    ),
    15 => array(
        'type'  => 'edit_event',
        'title' => 'Редактирование мероприятий',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => true,
        'u'      => false
    ),
    16 => array(
        'type'  => 'del_event',
        'title' => 'Удаление мероприятий',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => true,
        'u'      => false
    ),
    17 => array(
        'type'  => 'edit_comm',
        'title' => 'Редактирование комментариев',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => true,
        'u'      => false
    ),
    18 => array(
        'type'  => 'del_comm',
        'title' => 'Удаление комментариев',
        'o'      => true,
        'a'      => true,
        'e'      => true,
        'm'      => true,
        'u'      => false
    )
);
