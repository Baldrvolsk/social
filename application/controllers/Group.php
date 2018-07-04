<?php


class Group extends CI_Controller
{
    public $user;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('group_model');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->user = $this->ion_auth->user()->row();
    }

    public function index() {
        $data['groups'] = $this->group_model->get_all_groups();
        $this->load->view('header', $data);
        $this->load->view('group/index');
        $this->load->view('footer');
    }

    public function my_groups() {
        $data['groups'] = $this->group_model->get_my_groups($this->user->id);
        $this->load->view('header', $data);
        $this->load->view('group/my_groups');
        $this->load->view('footer');
    }

    public function view_group($id) {
        $data = array();
        $this->load->view('header', $data);
        $this->load->view('group/view_group');
        $this->load->view('footer');
    }

    public function follow_group($user_id, $group_id) {
        $ret = $this->group_model->follow_group($user_id, $group_id);
        echo $ret;
    }

    public function form_new_group() {
        $user_meta = $this->ion_auth->get_meta($this->user->id, array('leptas'));

        if (empty($user_meta->leptas)) {
            $data['leptas'] = 0;
            $this->load->view('group/need_money', $data);
        } elseif ($user_meta->leptas < 10) {
            $data['leptas'] = $user_meta->leptas;
            $this->load->view('group/need_money', $data);
        } else {
            $data = array();
            $this->load->view('group/new', $data);
        }

    }

    public function create_group() {
        $this->form_validation->set_error_delimiters('', '');
        if($this->form_validation->run() === FALSE){
            $res['status'] = "ERR";
            $res['name_err'] = $this->form_validation->error('name');
            $res['slogan_err'] = $this->form_validation->error('slogan');
            $res['description_err'] = $this->form_validation->error('description');
            $res['message'] = 'Проверьте правильность заполнения формы3';
        } else {
            $data['name'] = $this->input->post('name');
            $data['slogan'] = $this->input->post('slogan');
            $data['description'] = $this->input->post('description');
            $data['create_date'] = mdate('%Y-%m-%d %H:%i:%s', now());

            //Папка с фотками группы
            $data['group_dir'] = DS.'uploads'.DS.'group'.DS.md5($data['name']);
            if (!is_dir(WEBROOT.$data['group_dir'])) {
                mkdir(WEBROOT.$data['group_dir'], 0755);
            }
            //Загрузка фото
            if (!empty($_FILES['label']['name'])) {
                $config['upload_path'] = WEBROOT.$data['group_dir'];
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = 'label';
                $config['max_size'] = 100;
                $config['max_width'] = 1024;
                $config['max_height'] = 768;

                $this->load->library('upload', $config);
                if ( $this->upload->do_upload('label')) {
                    $data['label'] = $data['group_dir'].'/'.$this->upload->data('file_name');
                    if (!$this->group_model->add_new_group($data, $this->user->id)) {
                        $res['status'] = "OK";
                        $res['message'] = 'Группа успешно создана';
                    } else {
                        $res['status'] = "ERR";
                        $res['message'] = 'Что-то пошло не так';
                    }
                } else {
                    //echo $this->upload->display_errors('', '');
                    $res['status'] = "ERR";
                    $res['label_err'] = $this->upload->display_errors('', '');
                    $res['message'] = 'Проверьте правильность заполнения формы2';
                }
            } else {
                $res['status'] = "ERR";
                $res['label_err'] = 'Не загружен файл';
                $res['message'] = 'Проверьте правильность заполнения формы1';
            }
        }
        echo json_encode($res);
    }
}