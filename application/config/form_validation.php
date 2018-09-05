<?php
//правила валидации форм
$config = array(
    'regUser' => array( //регистрация
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|is_unique[user.email]'
        ),
        array(
            'field' => 'login',
            'label' => 'Логин',
            'rules' => 'trim|required|min_length[3]|max_length[100]|is_unique[user.username]'
        ),
        array(
            'field' => 'first_name',
            'label' => 'Имя',
            'rules' => 'trim|required|min_length[2]|max_length[100]'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Фамилия',
            'rules' => 'trim|min_length[2]|max_length[100]'
        ),
        array(
            'field' => 'google_photo',
            'label' => 'Аватар',
            'rules' => 'required'
        ),
        array(
            'field' => 'gender',
            'label' => 'Пол',
            'rules' => 'trim|in_list[ns,male,female]'
        ),
        array(
            'field' => 'rules',
            'label' => 'Правила',
            'rules' => 'required|in_list[true,1]',
            'errors' => array(
                'required' => 'Вы должны принять правила проекта',
                'in_list' => 'Вы должны принять правила проекта',
            )
        ),
        /*
        // убрано по приказу начальника
        array(
            'field' => 'privacy',
            'label' => 'Политика',
            'rules' => 'required|in_list[true,1]',
            'errors' => array(
                'required' => 'Вы должны дать согласие на обработку персональных данных',
                'in_list' => 'Вы должны дать согласие на обработку персональных данных',
            )
        ),
        */
    ),

    'postAdd' => array(
        array(
            'field' => 'owner_id',
            'label' => 'ID пользователя',
            'rules' => 'trim|required|integer'
        ),
        array(
            'field' => 'add_id',
            'label' => 'ID добавившего пост',
            'rules' => 'trim|required|integer'
        ),
        array(
            'field' => 'content',
            'label' => 'Сообщение',
            'rules' => 'trim|required'
        )
    ),

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
);