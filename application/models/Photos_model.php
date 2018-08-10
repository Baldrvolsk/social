<?php

class Photos_model extends CI_Model
{
    private $album_table  = 'albums';
    private $photos_table = 'photos';

    public function __construct() {

    }

    public function create_album($name = '', $description = '', $user_id = 0, $status = 0) {
        $data['user_id'] = (int)$user_id;
        if ($user_id == 0) {
            $data['user_id'] = $this->user->id;
        }
        $data['name'] = $name;
        $data['description'] = $description;
        $data['status'] = $status;
        $this->db->insert('albums', $data);
        $album_id = $this->db->insert_id();
        $album_dir = WEBROOT.DS.'uploads'.DS.'albums'.DS.$album_id;
        if (!is_dir($album_dir)) {
            mkdir($album_dir, 0755, true);
        }
    }

    public function get_albums() {
        $subselect = '(select file FROM photos WHERE album_id = albums.id ORDER BY id DESC LIMIT 0,1 ) as last_photo';
        $this->db->select("*,$subselect");
        $this->db->from($this->album_table);
        $this->db->where('user_id', $this->user->id);
        return $this->db->get()->result();
    }

    public function get_album($album_id = 0) {
        $this->db->where('user_id', $this->user->id);
        if ((int)$album_id != 0) {
            $this->db->where('album_id', (int)$album_id);
        }
        return $this->db->get('photos')->result();
    }

    public function get_last($user_id = 0, $limit = 0) {
        $this->db->where('user_id', (int)$user_id);
        $this->db->order_by('id', 'DESC');
        if ($limit > 0) {
            $this->db->limit((int)$limit);
        }
        return $this->db->get('photos')->result();
    }

    public function add_photo($album_id = 0) {
        if ($album_id == 0) {
            $album_id = $this->input->post('album_id');
        }
        if ($this->check_album($album_id, $this->user->id)) {
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
                    $this->db->insert('photos', $data);
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

    public function check_album($album_id = 0, $user_id = 0) {
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('id', $album_id);
        $query = $this->db->get($this->album_table);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function download_photo($url = '', $user_id = 0) {
        if ((int)$user_id != 0) {
            $tmp = explode('.', $url);
            $ext = end($tmp); //Расширение файла
            $photo = file_get_contents($url);
            $album_id = $this->get_profile_album($user_id); //Взять номер альбома с фотками профиля
            $filename = uniqid() . '.' . $ext;
            $full_path = "/uploads/albums/$album_id/$filename";
            file_put_contents(".$full_path", $photo);

            //Записать в бд
            $data['album_id'] = $album_id;
            $data['user_id'] = $user_id;
            $data['file'] = $full_path;
            $this->db->insert('photos', $data);
            return $full_path;
        }
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