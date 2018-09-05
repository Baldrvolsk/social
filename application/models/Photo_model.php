<?php
//echo '<pre>'; var_dump($query->result()); echo '</pre>'; die();

/**
 * Class Photo_model
 * Класс для работы с фотографиями и альбомами пользователей и сообществ
 */
class Photo_model extends CI_Model
{
    /**
     * @var string $type тип модели пользователь|сообщество
     */
    private $type;

    /**
     * @var string $album_table таблица альбомов
     */
    private $album_table;

    /**
     * @var string $photo_table таблица фотографий
     */
    private $photo_table;

    /**
     * @var int $owner_id id пользователя|сообщества владельца альбома|фотографии
     */
    private $owner_id;

    /**
     * @var int $create_id для альбомов|фотографий сообщества id пользователя
     *                     создавшего альбом или загрузившего фотографию
     */
    private $create_id;

    /**
     * @var array $albums массив всех альбомов пользователя|группы
     */
    public $albums;

    /**
     * Photo_model constructor.
     */
    public function __construct() {
        $this->load->model('media_model');
        $this->config->load('photos', TRUE);
    }

    /**
     * Инициализация модели Photo
     *
     * @param string   $type тип создаваемой модели user|community
     * @param null|int $owner_id владелец модели id пользователя/группы, если не
     *                           указано, то модель создается для текущего
     *                           авторизованного пользователя
     * @param null|int $create_id для модели пользователя должна быть null, для
     *                            модели группы: если int то id пользователя создавшего
     *                            альбом, если null берется id авт. пользователя
     *
     * @return $this возвращает экземпляр объекта
     */
    public function init($type, $owner_id = null, $create_id = null) {
        $this->type = $type;
        $this->album_table = $type.'_album';
        $this->photo_table = $type.'_photo';
        $this->owner_id = $owner_id;
        $this->create_id = $create_id;

        if ($this->owner_id !== null) {
            if (!$this->check_owner_albums()) {
                $this->create_default_albums();
            }
        }
    }

    /**
     *
     * @param null $id
     *
     * @return bool
     */
    private function check_owner_albums($id = null) {
        $check_id = isset($id)?$id:$this->owner_id;
        $query = $this->db->where($this->type.'_id', $check_id)
                          ->get($this->album_table);
        if ($query->num_rows() > 0) {
            $this->albums = $query->result();
            return true;
        } else {
            return false;
        }
    }

    private function create_default_albums() {
        $d_album = $this->config->item('default_'.$this->type.'_album', 'photos');
        foreach ($d_album as $key => $album) {
            if ($key === 0) {
                $album['status'] = 1;
            }
            $album[$this->type.'_id'] = $this->owner_id;
            if ($this->create_id !== null) {
                $album['user_create_id'] = $this->create_id;
            }
            $this->db->insert($this->album_table, $album);
        }
        $this->check_owner_albums();
    }

    public function create_album($name = '', $description = '', $id = null, $status = 0) {
        $key = $this->type.'_id';
        $data[$key] = (int)$id;
        $data['name'] = $name;
        $data['description'] = $description;
        $data['status'] = $status;
        $this->db->insert($this->album_table, $data);
        return $this->db->insert_id();

    }

    public function add_reg_avatar($media_id, $user_id) {
        $media = $this->media_model->get_media($media_id);
        $this->media_model->resize_avatar($media);
        // добавляем пользователю id аватара
        $this->ion_auth->update($user_id, array('avatar' => $media_id));
        // добавлеем запись в альбом пользователя
        $album = $this->get_albums($user_id, array('name' => 'Фотографии профиля'));
        $data = array(
            'album_id' => $album->id,
            'media' => $media_id,
            'description' => '',
        );
        $this->db->insert($this->photo_table, $data);
    }

    public function last_owner_photo($owner_id) {
        $ret['count'] = $this->db->select('COUNT(`p`.`id`) as `count`')
            ->from($this->photo_table.' as `p`')
            ->join($this->album_table.' as `a`', '`p`.`album_id` = `a`.`id`')
            ->where('`a`.`'.$this->type.'_id`', (int)$owner_id)
            ->group_by('`p`.`id`')
            ->get()->row()->count;

        $ret['photo'] = $this->db->select('`p`.*, `a`.*')
            ->from($this->photo_table.' as `p`')
            ->join($this->album_table.' as `a`', '`p`.`album_id` = `a`.`id`')
            ->where('`a`.`'.$this->type.'_id`', (int)$owner_id)
            ->order_by('`p`.`date_add`', 'DESC')
            ->limit(4)
            ->group_by('`p`.`id`')
            ->get()->result();
        return $ret;
    }

    public function get_albums($owner_id = null, $where = array()) {
        $id = (empty($owner_id))?$this->owner_id:$owner_id;
        if (!empty($where)) $this->db->where($where);
        $query =  $this->db->where($this->type.'_id', $id)
                           ->get($this->album_table);
        if ($query->num_rows() > 1) {
            return $this->albums = $query->result();
        } elseif ($query->num_rows() === 1) {
            return $this->albums = $query->row();
        } else {
            return null;
        }
    }

    public function get_album_photos($id) {
        return $this->db->where('album_id', $id)
                        ->get($this->photos_table)->result();
    }

    public function get_cover($id) {
        return $this->db->where('album_id', (int)$id)
                        ->order_by('id', 'DESC')
                        ->limit(1)
                        ->get($this->photos_table)->row();
    }

    public function add_photo($album_id = 0, $type_id = 0, $url = null) {
        if ($album_id == 0) {
            $album_id = $this->input->post('album_id');
        }
        if ($type_id == 0) {
            $type_id = $this->input->post('type_id');
        }
        if ($this->check_album($album_id, $type_id)) {
            //Загрузка фото
            if (!empty($_FILES['photo']['name'])) {
                $config['upload_path'] = './uploads/albums/' . $album_id;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['file_name'] = 'active';
                $config['max_size'] = 1000;
                $config['encrypt_name'] = true;
                $config['max_width'] = 10024;
                $config['max_height'] = 10768;

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('photo')) {
                    $path = '/uploads/albums/' . $album_id . '/' . $this->upload->data('file_name');
                    $data['user_id'] = $this->user->id;
                    $data['album_id'] = (int)$album_id;
                    $data['description'] = $this->input->post('description');
                    $data['file'] = $path;
                    $this->db->insert('Photo', $data);
                    return $path;
                    #print_r($this->db->last_query());die();
                } else {
                    #die('Ошибка загрузки файла');
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);
                    die();
                }
            }
        }
    }

    public function check_album($album_id = 0, $type_id = 0) {
        $query = $this->db->where($this->type.'_id', (int)$type_id)
                 ->where('id', $album_id)
                 ->get($this->album_table);
        return ($query->num_rows() > 0)?true:false;
    }



    public function get_profile_album($user_id) {
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('status', 1);
        $album = $this->db->get('albums')->row();
        return $album->id;

    }

    public function get_avatars($user_id = 0) {
        if ($user_id != 0) {
            return $this->db->query('SELECT * FROM photos WHERE album_id in (SELECT id FROM albums WHERE user_id = ' .
                                    (int)$user_id . ' AND status = 1)')->result();
        }
    }

    public function update_avatar($file = '') {
        if ($file != '') {
            $this->db->where('id', $this->user->id);
            $this->db->set('company', $file);
            $this->db->update('users');
        }
    }
}