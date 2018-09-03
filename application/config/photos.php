<?php
//альбому создаваемые по умолчанию, первым должен идти альбом который активен
$config['default_user_album'] = array( // альбомы пользователя
    array(
        'name' => 'Фотографии профиля',
        'description' => '',
        'cover' => 'null',
    ),
    array(
        'name' => 'Сохраненные фотографии',
        'description' => '',
        'cover' => 'null',
    ),
);
$config['default_community_album'] = array( // альбомы сообщества
    array(
        'name' => 'Фотографии группы',
        'description' => '',
        'cover' => 'null',
    ),
);

$config['photo_profile_size'] = 250;
$config['avatar_size'] = 50;
$config['thumb_size'] = array('w' => 100, 'h' => 70);
$config['cover_size'] = array('w' => 190, 'h' => 130);