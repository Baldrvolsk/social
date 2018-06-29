<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('login', 'Логин', 'required|min_length[5]|is_unique[users.username]');
        $this->form_validation->set_rules('first_name', 'Имя', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Пароль', 'required|min_length[4]');
        $this->form_validation->set_rules('password_confirm', 'Подтверждение пароля', 'required|min_length[4]');
        //Если есть поле с фоткой гугла
        if($this->input->post('google_photo')) {

        } else {
                $this->form_validation->set_rules('photo', 'Фото', 'required');
        }
        //Если валидация не прошла
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header');
            $this->load->view('auth/register');
            $this->load->view('footer');
        } else {
            //Создание пользователя
            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'gender' => $this->input->post('gender'),
                'country' => $this->input->post('country'),
                );
            $group = array('2');
            $user_id = $this->ion_auth->register($this->input->post('login'), $this->input->post('password'), $this->input->post('email'),$additional_data , $group);
            $this->ion_auth->login($this->input->post('email'),$this->input->post('password'),true);
            //Папка с фотками юзера
            $this->load->model('photos_model');
            //Создание альбомов профиля и сохраненных фото
            $this->photos_model->create_album('Фотографии профиля','',$user_id,1);
            $this->photos_model->create_album('Сохраненные фотографии','',$user_id);

            if (!is_dir('./uploads/profile/'.$user_id)) {
                mkdir('./uploads/profile/' . $user_id, 0755);
            }
            //Загрузка фото
            if (!empty($_FILES['photo']['name'])) {
                $config['upload_path'] = './uploads/profile/'.$user_id;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = 'active';
                $config['max_size'] = 100;
                $config['max_width'] = 1024;
                $config['max_height'] = 768;

                $this->load->library('upload', $config);
                if ( $this->upload->do_upload('photo')) {
                    $path = 'uploads/profile/'.$user_id.'/'.$this->upload->data('file_name');
                    $this->db->set('company',$path);
                    $this->db->where('id',$user_id);
                    $this->db->update('users');
                } else {
                    #die('Ошибка загрузки файла');
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);
                    die();
                }
            } else {
                //Скачивание с гугла
                $file_path = $this->photos_model->download_photo($this->input->post('google_photo'),$user_id);
                $this->db->set('company',$file_path);
                $this->db->where('id',$user_id);
                $this->db->update('users');
                #print_r($this->input->post('google_photo'));die();
            }

            redirect("profile/$user_id");

        }
    }
}
