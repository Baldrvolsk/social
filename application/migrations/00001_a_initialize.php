<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property mixed dbforge
 * @property mixed db
 * @property mixed config
 * @property mixed load
 */
class Migration_initialize extends CI_Migration {
	private $tables;

	public function __construct() {
		parent::__construct();
		$this->load->config('ion_auth', TRUE);
		$this->tables = $this->config->item('tables', 'ion_auth');
	}

	public function up() {
	    // Дропаем БД
        $tables = $this->db->list_tables();
        $this->db->query('SET foreign_key_checks = 0');
        foreach ($tables as $t) {
            if ($t === 'migrations') continue;
            $this->dbforge->drop_table($t);
        }

		// Создаем таблицу групп пользователей
		$this->dbforge->add_field(array(
			'id' => array('type' => 'TINYINT', 'constraint' => '3', 'unsigned' => TRUE),
			'name' => array('type' => 'VARCHAR', 'constraint' => '20'),
			'description' => array('type' => 'VARCHAR', 'constraint' => '100')
		));
		$this->dbforge->add_key('id');
		$this->dbforge->create_table($this->tables['groups']);

		// Пишем в таблицу группы по умолчанию
		$data = array(
            array('id' => 1, 'name' => 'delete', 'description' => 'Delete User'),
		    array('id' => 10, 'name' => 'newbie', 'description' => 'Newbie'),
            array('id' => 20, 'name' => 'member', 'description' => 'Full Member'),
            array('id' => 30, 'name' => 'verified', 'description' => 'Verified Account'),
            array('id' => 40, 'name' => 'vip', 'description' => 'V.I.P.'),
            array('id' => 100, 'name' => 'moderator', 'description' => 'Moderator'),
			array('id' => 200, 'name' => 'admin', 'description' => 'Administrator'),
            array('id' => 201, 'name' => 'sup_admin', 'description' => 'Super Administrator'),
            array('id' => 202, 'name' => 'owner', 'description' => 'Owner'),
		);
		$this->db->insert_batch($this->tables['groups'], $data);

		// Таблица пользователей
		$this->dbforge->add_field(array(
			'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'username' => array('type' => 'VARCHAR', 'constraint' => '100'),
			'password' => array('type' => 'VARCHAR', 'constraint' => '255'),
			'email' => array('type' => 'VARCHAR', 'constraint' => '255'),
            '`created_on` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'ip_address' => array('type' => 'VARCHAR', 'constraint' => '45'),
            '`last_login` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'active' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'unsigned' => TRUE,
                'null' => TRUE,
                'default' => 1
            ),
            'activation_code' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE, 'default' => null),
			'forgotten_password_code' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE, 'default' => null),
            '`forgotten_password_time` TIMESTAMP NULL DEFAULT NULL',
            'remember_code' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE, 'default' => null),
			'first_name' => array( 'type' => 'VARCHAR', 'constraint' => '100'),
			'last_name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'default' => ''),
            'gender' => array('type' => "SET('ns','male','female')", 'default' => 'ns'),
			'country_id' => array('type' => 'INT', 'null' => TRUE, 'default' => null),
			'city_id' => array('type' => 'INT', 'null' => TRUE, 'default' => null),
            'avatar' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'null' => TRUE, 'default' => null)
		));

        $this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($this->tables['users']);
        $this->db->query('ALTER TABLE `'.$this->tables['users'].'` ADD UNIQUE(`username`)');
        $this->db->query('ALTER TABLE `'.$this->tables['users'].'` ADD UNIQUE(`email`)');

		// Пишем в таблицу пользователей админа по умолчанию
		$data = array(
			'username'   => 'Baldr',
			'password'   => '$2y$10$fgvbd/j22hXgwLDeu7AgK.YvhtZvlFkEpAaEX6BJKhb92rXIZNjSC',
			'email'      => 'baldr.volsk@gmail.com',
            'ip_address' => '88.147.166.211',
            'active'     => '1',
			'first_name' => 'Ivan',
			'last_name'  => 'Semin',
			'country_id' => '2017370',
			'city_id'    => '472278',
            'avatar'     => '1'
		);
		$this->db->insert($this->tables['users'], $data);

		// Таблица связи пользователи - группы
		$this->dbforge->add_field(array(
			'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
			'group_id' => array('type' => 'TINYINT', 'constraint' => '3', 'unsigned' => TRUE)
		));
		$this->dbforge->add_key('user_id', TRUE);
		$this->dbforge->create_table($this->tables['users_groups']);

        $this->db->query('ALTER TABLE `'.$this->tables['users_groups'].'` 
                          ADD INDEX `user_group` (`user_id`, `group_id`)');
        $this->db->query('ALTER TABLE `'.$this->tables['users_groups'].'` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `'.$this->tables['users_groups'].'` 
                          ADD FOREIGN KEY (`group_id`) REFERENCES `'.$this->tables['groups'].'`(`id`)
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

		// Пишем группу для админа по умолчанию
		$data = array(
			array('user_id'  => '1', 'group_id' => '201',)
		);
		$this->db->insert_batch($this->tables['users_groups'], $data);

		// таблица попыток входа
		$this->dbforge->add_field(array(
			'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'ip_address' => array('type' => 'VARCHAR', 'constraint' => '45'),
			'login' => array('type' => 'VARCHAR', 'constraint' => '100'),
            '`time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($this->tables['login_attempts']);
        $this->db->query('ALTER TABLE `'.$this->tables['login_attempts'].'` ADD INDEX `login` (`login`)');

        // Таблица мета-данных пользователя
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'count_day_like' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
            'all_like' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
            'all_dislike' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
            'max_delta' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
            'leptas' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
            'max_leptas' => array('type' => 'INT', 'default' => 0, 'unsigned' => TRUE,),
            'online' => array('type' => 'TINYINT', 'constraint' => 128, 'default' => 0, 'unsigned' => TRUE),
            '`last_group_create` TIMESTAMP NULL DEFAULT NULL',
            'text_status' => array('type' => 'VARCHAR', 'null' => true, 'default' => null,'constraint' => 512),
            'birth' => array('type' => 'DATE', 'null' => true, 'default' => null),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user_meta');
        $this->db->query('ALTER TABLE `user_meta` 
                          ADD FOREIGN KEY (`id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        $data = array(
            'id' => 1,
        );
        $this->db->insert('user_meta', $data);


        // Таблица друзей
        $this->dbforge->add_field(array(
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'friend_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'friend_status' => array(
                'type' => "SET('request','confirmed','subscriber','blacklist')",
                'default' => 'request',
            ),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`last_edit` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ));
        $this->dbforge->create_table('friend');
        $this->db->query('ALTER TABLE `friend` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `friend` ADD INDEX `friend_id` (`friend_id`)');
        $this->db->query('ALTER TABLE `friend` ADD INDEX `user_friend` (`user_id`, `friend_id`)');
        $this->db->query('ALTER TABLE `friend` ADD FOREIGN KEY (`user_id`) 
                          REFERENCES `user`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `friend` ADD FOREIGN KEY (`friend_id`) 
                          REFERENCES `user`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT');


        // Таблица сообществ
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => 128),
            '`create_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'slogan' => array('type' => 'VARCHAR', 'constraint' => 512),
            'description' => array('type' => 'TEXT'),
            'avatar' => array('type' => 'TEXT'),
            'head_img' => array('type' => 'TEXT'),
            'rules' => array('type' => 'JSON'),
            'setting' => array('type' => 'JSON'),
            'type' => array('type' => "SET('open','close')", 'default' => 'open'),
            '`delete_time` TIMESTAMP NULL DEFAULT NULL',
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('community');
        $this->db->query('ALTER TABLE `community` ADD INDEX `name` (`name`)');

        // Таблица ролей сообщества
        $this->dbforge->add_field(array(
            'id' => array('type' => 'TINYINT', 'unsigned' => TRUE, 'constraint' => 2),
            'name' => array('type' => 'VARCHAR', 'constraint' => 50),
            'type' => array('type' => 'VARCHAR', 'constraint' => 1)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('community_group');

        // Данные для таблицы ролей сообщества
        $data = array(
            array('id' => '10', 'name' => 'member', 'type' => 'u'),
            array('id' => '20', 'name' => 'moderator', 'type' => 'm'),
            array('id' => '30', 'name' => 'editor', 'type' => 'e'),
            array('id' => '40', 'name' => 'administrator', 'type' => 'a'),
            array('id' => '50', 'name' => 'owner', 'type' => 'o'),
        );
        $this->db->insert_batch('community_group', $data);

        // Таблица участников сообщества
        $this->dbforge->add_field(array(
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'community_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'community_group_id' => array('type' => 'TINYINT', 'unsigned' => TRUE, 'constraint' => 2),
            'contact' => array('type' => 'BOOLEAN', 'default' => false)
        ));
        $this->dbforge->create_table('community_user');
        $this->db->query('ALTER TABLE `community_user` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `community_user` ADD INDEX `com_id` (`community_id`)');
        $this->db->query('ALTER TABLE `community_user` ADD INDEX `com_gr_id` (`community_group_id`)');
        $this->db->query('ALTER TABLE `community_user` ADD INDEX `user_community` (`user_id`, `community_id`)');
        $this->db->query('ALTER TABLE `community_user` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `community_user` 
                          ADD FOREIGN KEY (`community_id`) REFERENCES `community`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `community_user` 
                          ADD FOREIGN KEY (`community_group_id`) REFERENCES `community_group`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица мероприятий
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'community_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => 128),
            '`create_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`event_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'slogan' => array('type' => 'VARCHAR', 'constraint' => 512),
            'description' => array('type' => 'TEXT'),
            'avatar' => array('type' => 'TEXT'),
            'head_img' => array('type' => 'TEXT'),
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('event');
        $this->db->query('ALTER TABLE `event` ADD INDEX `com_id` (`community_id`)');
        $this->db->query('ALTER TABLE `event` ADD INDEX `name` (`name`)');
        $this->db->query('ALTER TABLE `event` 
                          ADD FOREIGN KEY (`community_id`) REFERENCES `community`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица участников мероприятий
        $this->dbforge->add_field(array(
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'event_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'contact' => array('type' => 'BOOLEAN', 'default' => false)
            ));
        $this->dbforge->create_table('event_user');
        $this->db->query('ALTER TABLE `event_user` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `event_user` ADD INDEX `event_id` (`event_id`)');
        $this->db->query('ALTER TABLE `event_user` ADD INDEX `user_event` (`user_id`, `event_id`)');
        $this->db->query('ALTER TABLE `event_user` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `event_user` 
                          ADD FOREIGN KEY (`event_id`) REFERENCES `event`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // таблица статических страниц
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'name' => array('type' => 'VARCHAR', 'constraint' => 128),
            '`last_edit` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'head' => array('type' => 'TEXT'),
            'title' => array('type' => 'TEXT'),
            'descr' => array('type' => 'TEXT'),
            'keywords' => array('type' => 'TEXT'),
            'content' => array('type' => 'TEXT'),
            ));
        $this->dbforge->create_table('static_page');
        $this->db->query('ALTER TABLE `static_page` ADD UNIQUE `name` (`name`)');

        // Контент статических страниц
        $data = array(
            array(
                'id'        => 1,
                'name'      => 'rules',
                'last_edit' => '2018-08-22 12:46:00',
                'head'      => 'Правила и Условия использования Монархической Социальной Сети<br>'
                              .'<a href="https://rusimperia.ru" title="RusImperia.Ru">РУССКАЯ ИМПЕРИЯ</a>',
                'title'     => 'Правила',
                'descr'     => 'Правила проекта RusImperia.ru',
                'keywords'  => 'rusimperia, русская, империя, правила, rules',
                'content'   => '<p>Настоящие Правила и Условия использования (далее – Правила) являются обязательными '
        .'для ВСЕХ пользователей сети интернет, которые пользуются, зарегистрировавшись в ней, нашей Социальной Сетью '
        .'расположенной по адресу <a href="https://rusimperia.ru">https://rusimperia.ru</a></p><p>Использование '
        .'Социальной Сети подразумевает полное и безоговорочное согласие с настоящими Правилами.</p>'
        .'<h2>Вход и регистрация</h2><ol><li>Регистрация пользователей осуществляется через Google OAuth2.0</li>'
        .'<li>Данные, предоставляемые при регистрации:<ul><li>e-mail (берется из Google аккаунта, изменить нельзя)</li>'
        .'<li>ник/логин латиницей (обязательное, любой незанятый)</li><li>имя (обязательное поле, можно использовать '
        .'любое имя, которое вам нравится <i class="far fa-smile"></i>)</li><li>фамилия (необязательное поле, можно '
        .'использовать любую фамилию, которая вам нравится <i class="far fa-smile"></i>)</li><li>аватар (обязательное '
        .'поле)</li><li>Страна, город – какие вам нравятся, не обязательно город реального проживания</li></ul></li>'
        .'<li>Авторизация: в один клик через Google</li></ol>'
        .'<h2>Функционал</h2><p>Пользователь может самостоятельно выбрать, кому видна его страница в сети интернет:</p>'
        .'<ul><li>всему интернету</li><li>зарегистрированным и авторизованным пользователям Монархической Социальной '
        .'Сети РУССКАЯ ИМПЕРИЯ</li><li>друзьям пользователя/членам закрытой группы</li></ul><p>Пользователь может '
        .'ставить как лайки (Нравится) так и дизлайки (Не нравится). Разница между этими значениями называется дельтой '
        .'и отображается под постом.</p><p>Пользователю дается ограниченное количество лайков/дизлайков в день, старт у '
        .'нового пользователя 100, с повышением статуса количество увеличивается, +50 за каждый более высокий класс '
        .'пользователя.</p><p>Автомодерация постов на основе Дельты - при дельте -10 скрывать пост, при 90% скрытых '
        .'таким образом постов из опубликованного пользователем - предупреждение с блокировкой на неделю, при '
        .'повторении - бан с обнулением результатов статистики от действий забаненного аккаунта.</p><p>Запрещено '
        .'использование ботов, сторонних приложений для автоматизации работы.</p><p>При выявлении – предупреждение с '
        .'блокировкой на 1 неделю, при повторном нарушении – бан с обнулением статистики</p><p>Суммарная дельта всех '
        .'постов пользователя выводится на его странице. +500дельт = 1 лепта. Лепта – валюта Проекта. В 2019 году '
        .'пользователи смогут обменять лепты на реальные деньги. Текущие котировки лепты можно посмотреть на ее сайте '
        .'(сейчас в разработке).</p><p>Начисление лепт на основе дельт производится еженедельно (в 00.00 GMT воскресенья.</p>'
        .'<h2>Система рейтингов</h2><ol><li>Система рейтинга пользователей/групп на основе дельты</li><li>Премирование '
        .'пользователей за рейтинг, начисление 1 лепты за каждые 500 единиц дельты</li><li>Статусы пользователей:<ul>'
        .'<li>0-100 лепт на балансе - Новичок (Newbie) иконка <i class="far fa-smile"></i></li>'
        .'<li>101-300 лепт - Участник (Full Member) могут безплатно поднимать свою страницу/страницу группы, где они '
        .'администраторы в поиске до 2 раз в месяц (всего). Иконка <i class="far fa-user"></i></li>'
        .'<li>301-1000 лепт - Верифицированный аккаунт (Verified Account) могут безплатно поднимать свою страницу/страницу '
        .'группы, где они администраторы в поиске до 10 раз в месяц (всего). Иконка <i class="fas fa-university"></i></li>'
        .'<li>1001+ лепт - V.I.P. могут скрывать свое присутствие, безплатно поднимать свою страницу/страницу группы, '
        .'где они администраторы в поиске до 25 раз в месяц (всего), приглашение на закрытые мероприятия. '
        .'Иконка <i class="fas fa-crown"></i></li></ul></li>'
        .'<li>Премирование групп за количество дельт, начисление определенного количества лепт на счет группы, можно '
        .'перевести на баланс администратора группы.</li><li>Единоразовое поднятие в поиске как человека, так и группы '
        .'(кроме мероприятия группы) на первое место за 3 лепты</li></ol>'
        .'<p class="bg-warning text-danger">Пользователи обязуются вести себя пристойно, не сквернословить, не богохульствовать, '
        .'не призывать к насилию в отношении людей/групп/стран. Запрещена русофобия и клевета на Святое Православие. '
        .'Нарушивших ждет предупреждение с блокировкой на неделю, а при повторном нарушении - бан. Соблюдение '
        .'пользователями закона/законов стран, гражданами которых они являются и на территории которых находятся, '
        .'является их обязанностью и в случае нарушения являются сугубо их виной. Администрация социальной сети '
        .'ответственности за противоправные действия пользователей и/или их контент НЕ несет.</p>'
        .'<p>Настоящим уведомляем, что данные, которые указывают пользователи не требуют никакой верификации и могут '
        .'быть изменены/удалены по их желанию в любой момент.Мы не предоставляем информацию о пользователях нашей '
        .'Социальной сети никаким сторонним сервисам/организациям, в том числе правительственным, государственным, '
        .'финансовым, правоохранительным и любым другим, так как не проверяем ее и не верифицируем.</p>'
            )
        );
        $this->db->insert_batch('static_page', $data);

        // Таблица пополнения баланса
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'lepta' => array('type' => 'INT', 'unsigned' => TRUE),
            'buy_type' => array('type' => 'VARCHAR', 'constraint' => 128, 'default' => 'admin'),
            '`create_trans` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`upd_trans` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'type_pay_system' => array('type' => 'VARCHAR', 'constraint' => 128, 'default' => 'admin'),
            'buy_status' => array('type' => 'VARCHAR', 'constraint' => 128, 'default' => 'paid'),
            'comment' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => TRUE),
            'trans_number' => array('type' => 'INT', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('buy');
        $this->db->query('ALTER TABLE `buy` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `buy` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица чатов
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'from' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'to' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            '`date_create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`date_upd` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('chat');
        $this->db->query('ALTER TABLE `chat` ADD INDEX `from_id` (`from`)');
        $this->db->query('ALTER TABLE `chat` ADD INDEX `to_id` (`to`)');
        $this->db->query('ALTER TABLE `chat` ADD INDEX `from_to` (`from`, `to`)');
        $this->db->query('ALTER TABLE `chat` 
                          ADD FOREIGN KEY (`from`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `chat` 
                          ADD FOREIGN KEY (`to`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица сообщений чатов
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'chat_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`date_upd` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'status' => array('type' => 'TINYINT', 'default' => 0, 'constraint' => 1),
            'content' => array('type' => 'TEXT', 'null' => TRUE),
            'media' => array('type' => 'TEXT', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('chat_message');
        $this->db->query('ALTER TABLE `chat_message` ADD INDEX `chat_id` (`chat_id`)');
        $this->db->query('ALTER TABLE `chat_message` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `chat_message` 
                          ADD FOREIGN KEY (`chat_id`) REFERENCES `chat`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `chat_message` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица постов пользователей
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_create_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`date_edit` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'post_content' => array('type' => 'TEXT', 'null' => TRUE),
            'media_type' => array('type' => 'VARCHAR', 'constraint' => 10, 'null' => TRUE),
            'media' => array('type' => 'TEXT', 'null' => TRUE),
            'tags' => array('type' => 'TEXT', 'null' => TRUE),
            'c_views' => array('type' => 'INT'),
            'c_like' => array('type' => 'INT'),
            'c_dislike' => array('type' => 'INT'),
            'c_comment' => array('type' => 'INT'),
            'c_shared' => array('type' => 'INT'),
            'no_comm' => array('type' => 'BOOLEAN', 'default' => false)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user_post');
        $this->db->query('ALTER TABLE `user_post` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `user_post` ADD INDEX `user_create_id` (`user_create_id`)');
        $this->db->query('ALTER TABLE `user_post` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `user_post` 
                          ADD FOREIGN KEY (`user_create_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица коментариев к постам пользователей
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'post_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`date_edit` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'comment_content' => array('type' => 'TEXT', 'null' => TRUE),
            'media_type' => array('type' => 'VARCHAR', 'constraint' => 10, 'null' => TRUE),
            'media' => array('type' => 'TEXT', 'null' => TRUE),
            'tags' => array('type' => 'TEXT', 'null' => TRUE),
            'c_like' => array('type' => 'INT'),
            'c_dislike' => array('type' => 'INT'),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user_post_comment');
        $this->db->query('ALTER TABLE `user_post_comment` ADD INDEX `post_id` (`post_id`)');
        $this->db->query('ALTER TABLE `user_post_comment` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `user_post_comment` 
                          ADD FOREIGN KEY (`post_id`) REFERENCES `user_post`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `user_post_comment` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица лайков постов пользователей
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'post_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'like' => array('type' => 'BOOLEAN'),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user_post_like');
        $this->db->query('ALTER TABLE `user_post_like` ADD INDEX `post_id` (`post_id`)');
        $this->db->query('ALTER TABLE `user_post_like` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `user_post_like` 
                          ADD FOREIGN KEY (`post_id`) REFERENCES `user_post`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `user_post_like` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица постов сообщества
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'community_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_create_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`date_edit` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'post_content' => array('type' => 'TEXT', 'null' => TRUE),
            'media_type' => array('type' => 'VARCHAR', 'constraint' => 10, 'null' => TRUE),
            'media' => array('type' => 'TEXT', 'null' => TRUE),
            'tags' => array('type' => 'TEXT', 'null' => TRUE),
            'c_views' => array('type' => 'INT'),
            'c_like' => array('type' => 'INT'),
            'c_dislike' => array('type' => 'INT'),
            'c_comment' => array('type' => 'INT'),
            'c_shared' => array('type' => 'INT'),
            'no_comm' => array('type' => 'BOOLEAN', 'default' => false),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('community_post');
        $this->db->query('ALTER TABLE `community_post` ADD INDEX `community_id` (`community_id`)');
        $this->db->query('ALTER TABLE `community_post` ADD INDEX `user_create_id` (`user_create_id`)');
        $this->db->query('ALTER TABLE `community_post` 
                          ADD FOREIGN KEY (`community_id`) REFERENCES `community`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `community_post` 
                          ADD FOREIGN KEY (`user_create_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица комментариев к постам сообщества
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'post_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`date_edit` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'comment_content' => array('type' => 'TEXT', 'null' => TRUE),
            'media_type' => array('type' => 'VARCHAR', 'constraint' => 10, 'null' => TRUE),
            'media' => array('type' => 'TEXT', 'null' => TRUE),
            'tags' => array('type' => 'TEXT', 'null' => TRUE),
            'c_like' => array('type' => 'INT'),
            'c_dislike' => array('type' => 'INT'),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('community_post_comment');
        $this->db->query('ALTER TABLE `community_post_comment` ADD INDEX `post_id` (`post_id`)');
        $this->db->query('ALTER TABLE `community_post_comment` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `community_post_comment` 
                          ADD FOREIGN KEY (`post_id`) REFERENCES `community_post`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `community_post_comment` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица лайков постов сообщества
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'post_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'like' => array('type' => 'BOOLEAN'),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('community_post_like');
        $this->db->query('ALTER TABLE `community_post_like` ADD INDEX `post_id` (`post_id`)');
        $this->db->query('ALTER TABLE `community_post_like` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `community_post_like` 
                          ADD FOREIGN KEY (`post_id`) REFERENCES `community_post`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `community_post_like` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица постов мероприятий
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'event_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_create_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`date_edit` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'post_content' => array('type' => 'TEXT', 'null' => TRUE),
            'media_type' => array('type' => 'VARCHAR', 'constraint' => 10, 'null' => TRUE),
            'media' => array('type' => 'TEXT', 'null' => TRUE),
            'tags' => array('type' => 'TEXT', 'null' => TRUE),
            'c_views' => array('type' => 'INT'),
            'c_like' => array('type' => 'INT'),
            'c_dislike' => array('type' => 'INT'),
            'c_comments' => array('type' => 'INT'),
            'c_shared' => array('type' => 'INT'),
            'no_comm' => array('type' => 'BOOLEAN', 'default' => false),
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('event_post');
        $this->db->query('ALTER TABLE `event_post` ADD INDEX `event_id` (`event_id`)');
        $this->db->query('ALTER TABLE `event_post` ADD INDEX `user_create_id` (`user_create_id`)');
        $this->db->query('ALTER TABLE `event_post` 
                          ADD FOREIGN KEY (`event_id`) REFERENCES `event`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `event_post` 
                          ADD FOREIGN KEY (`user_create_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица комментариев к постам мероприятий
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'post_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            '`date_edit` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'comment_content' => array('type' => 'TEXT', 'null' => TRUE),
            'media_type' => array('type' => 'VARCHAR', 'constraint' => 10, 'null' => TRUE),
            'media' => array('type' => 'TEXT', 'null' => TRUE),
            'tags' => array('type' => 'TEXT', 'null' => TRUE),
            'c_like' => array('type' => 'INT'),
            'c_dislike' => array('type' => 'INT'),
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('event_post_comment');
        $this->db->query('ALTER TABLE `event_post_comment` ADD INDEX `post_id` (`post_id`)');
        $this->db->query('ALTER TABLE `event_post_comment` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `event_post_comment` 
                          ADD FOREIGN KEY (`post_id`) REFERENCES `event_post`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `event_post_comment` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица лайков постов мероприятий
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'post_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'like' => array('type' => 'BOOLEAN'),
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('event_post_like');
        $this->db->query('ALTER TABLE `event_post_like` ADD INDEX `post_id` (`post_id`)');
        $this->db->query('ALTER TABLE `event_post_like` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `event_post_like` 
                          ADD FOREIGN KEY (`post_id`) REFERENCES `event_post`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `event_post_like` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица медиафайлов
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'cdn' => array('type' => 'BOOLEAN', 'default' => 0),
            'link' => array('type' => 'TEXT', 'null' => true),
            'type' => array('type' => 'VARCHAR', 'constraint' => 20),
            'file_hash' => array('type' => 'VARCHAR', 'constraint' => 40),
            'file_orig_name' => array('type' => 'VARCHAR', 'constraint' => 40),
            'file_ext' => array('type' => 'VARCHAR', 'constraint' => 10),
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('media');
        $this->db->query('ALTER TABLE `media` ADD INDEX `file_hash` (`file_hash`)');

        // Аватарка админа по умолчанию
        $avatar = array(
            'id' => 1,
            'cdn' => 0,
            'link' => NULL,
            'type' => 'image/jpeg',
            'file_hash' =>'24d2fe1b3961b499e058f9b7de2b170983176849',
            'file_orig_name' => 'admin',
            'file_ext' => 'jpg'
        );
        $this->db->insert('media', $avatar);

        // Таблица альбомов пользователей
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'user_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => 255),
            'description' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => TRUE, 'default' => null),
            'cover' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => TRUE, 'default' => null),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user_album');
        $this->db->query('ALTER TABLE `user_album` ADD INDEX `user_id` (`user_id`)');
        $this->db->query('ALTER TABLE `user_album` 
                          ADD FOREIGN KEY (`user_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Альбомы админа по умолчанию
        $albums = array(
            array('id' => 1, 'user_id' => 1, 'name' => 'Фотографии профиля', 'cover' => 1, 'status' => 1),
            array('id' => 2, 'user_id' => 1, 'name' => 'Сохраненные фотографии', 'cover' => null, 'status' => 0),
        );
        $this->db->insert_batch('user_album', $albums);

        // Таблица фотографий пользователей
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'album_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'media' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'description' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => TRUE, 'default' => null),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user_photo');
        $this->db->query('ALTER TABLE `user_photo` ADD INDEX `album_id` (`album_id`)');
        $this->db->query('ALTER TABLE `user_photo` 
                          ADD FOREIGN KEY (`album_id`) REFERENCES `user_album`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `user_photo` 
                          ADD FOREIGN KEY (`media`) REFERENCES `media`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Аватарка пользователя
        $photo = array('id' => 1, 'album_id' => 1, 'media' => 1, 'description' => '');
        $this->db->insert('user_photo', $photo);

        // Таблица альбомов сообщества
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'community_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_create_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => 255),
            'description' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => TRUE, 'default' => null),
            'cover' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => TRUE, 'default' => null),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('community_album');
        $this->db->query('ALTER TABLE `community_album` ADD INDEX `community_id` (`community_id`)');
        $this->db->query('ALTER TABLE `community_album` ADD INDEX `user_create_id` (`user_create_id`)');
        $this->db->query('ALTER TABLE `community_album` 
                          ADD FOREIGN KEY (`community_id`) REFERENCES `community`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `community_album` 
                          ADD FOREIGN KEY (`user_create_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        // Таблица фотографий сообщества
        $this->dbforge->add_field(array(
            'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'album_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'user_add_id' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'media' => array('type' => 'BIGINT', 'unsigned' => TRUE),
            'description' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => TRUE, 'default' => null),
            '`date_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('community_photo');
        $this->db->query('ALTER TABLE `community_photo` ADD INDEX `album_id` (`album_id`)');
        $this->db->query('ALTER TABLE `community_photo` ADD INDEX `user_add_id` (`user_add_id`)');
        $this->db->query('ALTER TABLE `community_photo` 
                          ADD FOREIGN KEY (`album_id`) REFERENCES `community_album`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `community_photo` 
                          ADD FOREIGN KEY (`user_add_id`) REFERENCES `'.$this->tables['users'].'`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');
        $this->db->query('ALTER TABLE `community_photo` 
                          ADD FOREIGN KEY (`media`) REFERENCES `media`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        //Таблица континентов
        $this->dbforge->add_field(array(
            'id' => array('type' => 'VARCHAR', 'constraint' => 2),
            'name_ru' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE, 'default' => null),
            'name_en' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE, 'default' => null)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geo_continent');

        //Таблица стран
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE),
            'continent_id' => array('type' => 'VARCHAR', 'constraint' => 2),
            'country_iso_code' => array('type' => 'VARCHAR', 'constraint' => 2),
            'name_ru' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE, 'default' => null),
            'name_en' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE, 'default' => null),
            'is_in_european_union' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geo_country');
        $this->db->query('ALTER TABLE `geo_country` ADD INDEX `continent_id` (`continent_id`)');
        $this->db->query('ALTER TABLE `geo_country` 
                          ADD FOREIGN KEY (`continent_id`) REFERENCES `geo_continent`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        //Таблица регионов
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE),
            'country_id' => array('type' => 'INT', 'unsigned' => TRUE),
            'subdivision_1_iso_code' => array('type' => 'VARCHAR', 'constraint' => 3),
            'subdivision_1_iso_name_ru' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE, 'default' => null),
            'subdivision_1_iso_name_en' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE, 'default' => null),
            'subdivision_2_iso_code' => array('type' => 'VARCHAR', 'constraint' => 3),
            'subdivision_2_iso_name_ru' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE, 'default' => null),
            'subdivision_2_iso_name_en' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE, 'default' => null)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geo_region');
        $this->db->query('ALTER TABLE `geo_region` ADD INDEX `country_id` (`country_id`)');
        $this->db->query('ALTER TABLE `geo_region` 
                          ADD FOREIGN KEY (`country_id`) REFERENCES `geo_country`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        //Таблица городов
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE),
            'country_id' => array('type' => 'INT', 'unsigned' => TRUE),
            'region_id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => TRUE, 'default' => null),
            'city_name_ru' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE, 'default' => null),
            'city_name_en' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE, 'default' => null),
            'time_zone_en' => array('type' => 'VARCHAR', 'constraint' => 128)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('geo_city');
        $this->db->query('ALTER TABLE `geo_city` ADD INDEX `country_id` (`country_id`)');
        $this->db->query('ALTER TABLE `geo_city` ADD INDEX `region_id` (`region_id`)');
        $this->db->query('ALTER TABLE `geo_city` 
                          ADD FOREIGN KEY (`country_id`) REFERENCES `geo_country`(`id`) 
                          ON DELETE RESTRICT ON UPDATE RESTRICT');

        //Таблица привязки IPv4 к региону
        $this->dbforge->add_field(array(
            'network' => array('type' => 'VARCHAR', 'constraint' => 20),
            'geoname_id' => array('type' => 'INT', 'unsigned' => TRUE),
            'latitude' => array('type' => 'VARCHAR', 'constraint' => 128),
            'longitude' => array('type' => 'VARCHAR', 'constraint' => 128),
            'time_zone_en' => array('type' => 'VARCHAR', 'constraint' => 128),
            'accuracy_radius' => array('type' => 'INT', 'unsigned' => TRUE),
        ));
        $this->dbforge->create_table('geo_ipv4');
        $this->db->query('ALTER TABLE `geo_ipv4` ADD INDEX `network` (`network`)');
        $this->db->query('ALTER TABLE `geo_ipv4` ADD INDEX `geoname_id` (`geoname_id`)');


        //Таблица привязки IPv6 к региону
        $this->dbforge->add_field(array(
            'network' => array('type' => 'VARCHAR', 'constraint' => 45),
            'geoname_id' => array('type' => 'INT', 'unsigned' => TRUE),
            'latitude' => array('type' => 'VARCHAR', 'constraint' => 128),
            'longitude' => array('type' => 'VARCHAR', 'constraint' => 128),
            'time_zone_en' => array('type' => 'VARCHAR', 'constraint' => 128),
            'accuracy_radius' => array('type' => 'INT', 'unsigned' => TRUE),
        ));
        $this->dbforge->create_table('geo_ipv6');
        $this->db->query('ALTER TABLE `geo_ipv6` ADD INDEX `network` (`network`)');
        $this->db->query('ALTER TABLE `geo_ipv6` ADD INDEX `geoname_id` (`geoname_id`)');

    }

	public function down() {
        log_message('info', 'Инициализирующую миграцию откатить нельзя');
        show_error('Инициализирующую миграцию откатить нельзя.');
    }
}
