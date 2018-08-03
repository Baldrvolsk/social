<?php


class Group extends CI_Controller
{
    public $user;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->config->load('group');
        $this->load->model('group_model');
        $this->load->model('group_post_model');
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->user = $this->ion_auth->user()->row();
        $this->user->create_group = $this->check_create_group();
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
        $this->get_rules($id);
        $group = $this->group_model->get_group($id);
        if (empty($group->head_img) || !file_exists(WEBROOT . $group->head_img)) {
            $group->head_img = '/img/750x250.png';
        }
        $data['group'] = $group;
        $data['contacts'] = $this->group_model->get_contacts($id);

        $formData['group_id'] = $id;
        $data['addPostForm'] = $this->load->view('post/group_add', $formData,true);
        $postData['posts'] = $this->group_post_model->get_group_post($id, 5);
        $data['posts'] = $this->load->view('post/group_index', $postData,true);

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
            $ret['status'] = "ERR";
            $ret['name_err'] = $this->form_validation->error('name');
            $ret['slogan_err'] = $this->form_validation->error('slogan');
            $ret['description_err'] = $this->form_validation->error('description');
            $ret['message'] = 'Проверьте правильность заполнения формы';
        } else {
            $data['name'] = $this->input->post('name');
            $data['slogan'] = $this->input->post('slogan');
            $data['description'] = $this->input->post('description');
            $data['type'] = $this->input->post('type');
            $data['create_date'] = mdate('%Y-%m-%d %H:%i:%s', now());
            $data['setting'] = json_encode($this->config->item('group_setting'));
            $data['rules'] = json_encode($this->config->item('group_rules'));
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
                if ($this->upload->do_upload('label')) {
                    $data['label'] = $data['group_dir'].DS.$this->upload->data('file_name');
                    if ($this->group_model->add_new_group($data, $this->user->id)) {
                        $ret['status'] = "OK";
                        $ret['message'] = 'Группа успешно создана';
                    } else {
                        $ret['status'] = "ERR";
                        $ret['message'] = 'Что-то пошло не так';
                    }
                } else {
                    $ret['status'] = "ERR";
                    $ret['label_err'] = $this->upload->display_errors('', '');
                    $ret['message'] = 'Проверьте правильность заполнения формы';
                }
            } else {
                $ret['status'] = "ERR";
                $ret['label_err'] = 'Не загружен файл';
                $ret['message'] = 'Проверьте правильность заполнения формы';
            }
        }
        echo json_encode($ret);
    }

    public function manage($group_id) {
        $data['group'] = $this->group_model->get_group($group_id);
        $this->load->view('header', $data);
        $this->load->view('group/setting');
        $this->load->view('footer');
    }

    public function save_group($id) {
        $this->form_validation->set_error_delimiters('', '');
        if($this->form_validation->run() === FALSE){
            $ret['status'] = "ERR";
            $ret['slogan_err'] = $this->form_validation->error('slogan');
            $ret['description_err'] = $this->form_validation->error('description');
            $ret['message'] = 'Проверьте правильность заполнения формы';
        } else {
            $data['slogan'] = $this->input->post('slogan');
            $data['description'] = $this->input->post('description');
            $data['type'] = $this->input->post('type');

            //Загрузка фото
            if (!empty($_FILES['label']['name'])) {
                $group = $this->group_model->get_group($id);
                $group_dir = $group->group_dir;
                $config['upload_path'] = WEBROOT.$group_dir;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = 'label';
                $config['max_size'] = 100;
                $config['max_width'] = 1024;
                $config['max_height'] = 768;

                $this->load->library('upload', $config);
                if ( $this->upload->do_upload('label')) {
                    $data['label'] = $group_dir.DS.$this->upload->data('file_name');
                    if ($this->group_model->update_group($data, $id)) {
                        $ret['status'] = "OK";
                        $ret['message'] = 'Информация о группе успешно обновлена';
                    } else {
                        $ret['status'] = "ERR";
                        $ret['message'] = 'Что-то пошло не так';
                    }
                } else {
                    $ret['status'] = "ERR";
                    $ret['label_err'] = $this->upload->display_errors('', '');
                    $ret['message'] = 'Проверьте правильность заполнения формы';
                }
            } else {
                if ($this->group_model->update_group($data, $id)) {
                    $ret['status'] = "OK";
                    $ret['message'] = 'Информация о группе успешно обновлена';
                } else {
                    $ret['status'] = "ERR";
                    $ret['message'] = 'Что-то пошло не так';
                }
            }
        }
        echo json_encode($ret);
    }

    public function save_setting($id) {
        $this->form_validation->set_error_delimiters('', '');
        if($this->form_validation->run() === FALSE){
            $ret['status'] = "ERR";
            $ret['wall_err'] = $this->form_validation->error('wall');
            $ret['albums_err'] = $this->form_validation->error('albums');
            $ret['event_err'] = $this->form_validation->error('event');
            $ret['message'] = 'Проверьте правильность заполнения формы';
        } else {
            $set['wall'] = $this->input->post('wall');
            $set['albums'] = $this->input->post('albums');
            $set['event'] = $this->input->post('event');
            $data['setting'] = json_encode($set);
            if ($this->group_model->update_group($data, $id)) {
                $ret['status'] = "OK";
                $ret['message'] = 'Информация о группе успешно обновлена';
            } else {
                $ret['status'] = "ERR";
                $ret['message'] = 'Что-то пошло не так. Err0';
            }
        }
        echo json_encode($ret);
    }

    public function check_create_group() {
        $ret = new stdClass();
        $u_m = $this->ion_auth->get_meta($this->user->id, array('last_group_create'));
        if (empty($u_m)) {
            $ret->status = true;
            return $ret;
        }
        if ($u_m->last_group_create === null) {
            $ret->status = true;
        } else {
            $dt = date_create();
            $lgc = date_create($u_m->last_group_create);
            date_add($lgc, new DateInterval($this->config->item('group_create_interval')));
            $ret->status = ($dt > $lgc)?true:false;
            if ($ret->status === false)
                $ret->time = date_diff($dt, $lgc)->format('%dд %Hч %Iм');
        }
        return $ret;
    }

    private function get_rules($id) {
        $this->user->com_gr_id = $this->group_model->get_user_com_gr_id($this->user->id, $id);
    }

    public function save_rules($id) {
        $data = array();
        $pre_data = $this->input->post();
        foreach ($pre_data as $key => $value) {
            $key = explode('_', $key);
            if (empty($data[$key['0']])) $data[$key['0']] = array();
            if (in_array($key['1'], array('o', 'a', 'e', 'm', 'u'))) {
                $value = ($value === 'on' || $value === 1) ? true : false;
            }
            $data[$key['0']] += array($key['1'] => $value);
        }
        foreach ($data as $key => $value) {
            $keys = array('o', 'a', 'e', 'm', 'u');
            foreach ($keys as $check) {
                if (!array_key_exists($check, $value)) {
                    $data[$key] += array($check => false);
                }
            }
        }
        $d['rules'] = json_encode($data);
        if ($this->group_model->update_group($d, $id)) {
            $ret['status'] = "OK";
            $ret['message'] = 'Информация о группе успешно обновлена';
        } else {
            $ret['status'] = "ERR";
            $ret['message'] = 'Что-то пошло не так. Err0';
        }
        echo json_encode($ret);
    }

    public function load_form($type, $group_id) {
        $data['group'] = $this->group_model->get_group($group_id);
        if ($type === 'change_head_img') {
            $this->load->view('group/change_head_img', $data);
        } else {
            echo 'Error';
        }
    }

    public function post_add() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        if ($this->form_validation->run() === FALSE) {
            $ret['status'] = "ERR";
            $ret['content'] = $this->form_validation->error('content');
            $ret['message'] = 'Проверьте правильность заполнения формы';
        } else {
            $data['user_create_id'] = $this->input->post('user_id');
            $data['group_id'] = $this->input->post('group_id');
            $data['content'] = $this->input->post('content');
            $data['date_add'] = mdate('%Y-%m-%d %H:%i:%s', now());
            if ($data['user_create_id'] != $this->user->id) {
                $ret['status'] = "ERR";
                $ret['message'] = 'Что-то пошло не так. Err1';
                goto ex;
            }
            if (!$this->group_model->check_group($data['group_id'])) {
                $ret['status'] = "ERR";
                $ret['message'] = 'Что-то пошло не так. Err2';
                goto ex;
            }
            if ($this->group_post_model->create_post($data)) {
                $ret['status'] = "OK";
                $ret['message'] = 'Пост успешно добавлен';
            } else {
                $ret['status'] = "ERR";
                $ret['message'] = 'Что-то пошло не так. Err3';
            }
        }
        ex:
        echo json_encode($ret);
    }
}