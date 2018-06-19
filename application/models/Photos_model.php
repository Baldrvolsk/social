<?php

class Photos_model extends CI_Model
{
    private $album_table = 'albums';
    private $photos_table = 'photos';

    public function __construct() {

    }

    public function create_album()
    {
        $data['user_id'] = $this->user->id;
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $this->db->insert('albums',$data);
        $album_id = $this->db->insert_id();
        $folder_name = md5($this->user->username);
        if (!is_dir('./uploads/albums/'.$album_id)) {
            mkdir('./uploads/albums/'.$album_id, 0755);
        }
    }

    public function get_albums()
    {
        $this->db->where('user_id',$this->user->id);
        return $this->db->get($this->album_table)->result();
    }

    public function get_album($album_id = 0)
    {
        if((int) $album_id != 0) {
            $this->db->where('album_id', (int) $album_id);
        }
        return $this->db->get('photos')->result();
    }

    public function add_photo()
    {
        if($this->check_album($this->input->post('album_id'), $this->user->id)) {
            $album_id = $this->input->post('album_id');
            //Загрузка фото
            if (!empty($_FILES['photo']['name'])) {
                $config['upload_path'] = './uploads/albums/'.$album_id;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['file_name'] = 'active';
                $config['max_size'] = 1000;
                $config['encrypt_name'] = true;
                $config['max_width'] = 10024;
                $config['max_height'] = 10768;

                $this->load->library('upload', $config);
                if ( $this->upload->do_upload('photo')) {
                    $path = '/uploads/albums/'.$album_id.'/'.$this->upload->data('file_name');
                    $data['user_id'] = $this->user->id;
                    $data['album_id'] = (int)$album_id;
                    $data['description'] = $this->input->post('description');
                    $data['file'] = $path;
                    $this->db->insert('photos',$data);
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

    public function check_album($album_id = 0,$user_id = 0)
    {
        $this->db->where('user_id',(int)$user_id);
        $this->db->where('id',$album_id);
        $query = $this->db->get($this->album_table);
        if($query->num_rows() > 0)
        {
            return true;
        } else {
            return false;
        }
    }
}