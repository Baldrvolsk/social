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