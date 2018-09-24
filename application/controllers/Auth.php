<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Auth extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('language'));
        $this->lang->load('auth');
    }

    public function index() {
        redirect('', 'refresh');
    }

    /**
     * Google auth
     *
     * @param void
     */
    public function login() {
        if ($this->ion_auth->logged_in()) {
            redirect('profile/'.$this->session->user_id, 'refresh');
        }
        $this->load->library('google');
        if (isset($_GET['code'])) {
            try {
                $this->google->getAuthenticate();
            } catch (Exception $e) {
                redirect('', 'refresh');
            }
            //get user info from google
            $gpInfo = $this->google->getUserInfo();

            if ($this->ion_auth->email_check($gpInfo['email'])) {
                $this->ion_auth->google_login($gpInfo['email']);
                redirect('profile/'.$this->session->user_id, 'refresh');
            } else {
                if (empty($gpInfo['gender'])) $gpInfo['gender'] = null;
                $data['google_info'] = $gpInfo;
                $tmp = explode('@', $gpInfo['email']);
                $data['google_info']['login'] = current($tmp);

                $this->theme
                    ->title('Страница регистрации')
                    ->add_partial('header')
                    ->add_partial('l_sidebar')
                    ->add_partial('r_sidebar')
                    ->add_partial('footer')
                    ->load('auth/register', $data);
            }
        } else {
            redirect('', 'refresh');
        }
    }

    /**
     * Log the user out
     */
    public function logout() {
        $this->ion_auth->set_meta($this->session->user_id, array('online' => false));
        $this->ion_auth->logout();
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('', 'refresh');
    }

    public function register() {
        if ($this->form_validation->run('regUser') == FALSE) { //Если валидация не прошла
            $ret['status'] = "ERR";
            $ret['email_err'] = $this->form_validation->error('email');
            $ret['login_err'] = $this->form_validation->error('login');
            $ret['f_name_err'] = $this->form_validation->error('first_name');
            $ret['l_name_err'] = $this->form_validation->error('last_name');
            $ret['photo_err'] = $this->form_validation->error('google_photo');
            $ret['gender_err'] = $this->form_validation->error('name');
            $ret['rules_err'] = $this->form_validation->error('rules');
            //$ret['country_err'] = $this->form_validation->error('country');
            $ret['message'] = 'Проверьте правильность заполнения формы';
            $ret['error'] = 'не прошла валидация';
        } else {
            // генерируем рандомный пароль
            $password = $this->ion_auth->salt();
            // Создание пользователя
            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'gender' => $this->input->post('gender'),
                'country' => $this->input->post('country'),
            );
            $group = array('10');
            $user_id = $this->ion_auth->register($this->input->post('login'),
                                                 $password,
                                                 $this->input->post('email'),
                                                 $additional_data,
                                                 $group);
            $this->ion_auth->set_meta($user_id);
            $this->ion_auth->login($this->input->post('email'),$password,true);
            //Создаем дефолтные альбомы пользователю
            $this->load->model('photo_model');
            $this->photo_model->init('user', $user_id);
            // загружаем аватар с гугла
            $media_id = $this->media_model->download_media($this->input->post('google_photo'));
            //добавляем аватар пользователю
            $this->photo_model->add_reg_avatar($media_id, $user_id);

            $ret['status'] = "OK";
            $ret['message'] = 'Регистрация прошла успешно';
        }
        echo json_encode($ret);
    }
}
