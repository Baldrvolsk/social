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
    )
);