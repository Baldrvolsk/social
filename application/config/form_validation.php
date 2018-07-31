<?php
$config = array(
    'group/create_group' => array(
        array(
            'field' => 'name',
            'label' => 'Название группы',
            'rules' => 'trim|required|min_length[5]|is_unique[community.name]'
        ),
        array(
            'field' => 'slogan',
            'label' => 'Слоган',
            'rules' => 'trim|required|min_length[25]'
        ),
        array(
            'field' => 'description',
            'label' => 'Описание',
            'rules' => 'trim|required|min_length[100]'
        ),
        array(
            'field' => 'type',
            'label' => 'Тип группы',
            'rules' => 'trim|required|in_list[open,close]'
        )
    ),
    'group/save_group' => array(
        array(
            'field' => 'slogan',
            'label' => 'Слоган',
            'rules' => 'trim|required|min_length[25]'
        ),
        array(
            'field' => 'description',
            'label' => 'Описание',
            'rules' => 'trim|required|min_length[100]'
        ),
        array(
            'field' => 'type',
            'label' => 'Тип группы',
            'rules' => 'trim|required|in_list[open,close]'
        )
    ),
    'group/save_setting' => array(
        array(
            'field' => 'wall',
            'label' => 'Стена',
            'rules' => 'trim|required|in_list[open,limited,close]'
        ),
        array(
            'field' => 'albums',
            'label' => 'Альбомы',
            'rules' => 'trim|required|in_list[open,close]'
        ),
        array(
            'field' => 'event',
            'label' => 'Мероприятия',
            'rules' => 'trim|required|in_list[open,limited,close]'
        )
    ),
    'group/post_add' => array(
        array(
            'field' => 'group_id',
            'label' => 'ID группы',
            'rules' => 'trim|required|integer'
        ),
        array(
            'field' => 'user_id',
            'label' => 'ID пользователя',
            'rules' => 'trim|required|integer'
        ),
        array(
            'field' => 'content',
            'label' => 'Сообщение',
            'rules' => 'trim|required'
        )
    )
);