<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 'id' => array('type' => 'BIGINT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
 * 'cdn' => array('type' => 'BOOLEAN', 'default' => 0),
 * 'link' => array('type' => 'TEXT', 'unsigned' => TRUE),
 * 'type' => array('type' => 'VARCHAR', 'constraint' => 20),
 * 'file_hash' => array('type' => 'VARCHAR', 'constraint' => 40),
 * 'file_orig_name' => array('type' => 'VARCHAR', 'constraint' => 40),
 * 'file_ext' => array('type' => 'VARCHAR', 'constraint' => 10),
*/
class Media extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        /*if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('', 'refresh');
        }*/
        $this->load->model('media_model');
    }

    public function index() {
        redirect('', 'refresh');
    }

    public function add($user_id) {

    }

    // ~ функции получения медиафайлов
    public function user($type, $id) {
        switch ($type) {
            case 'avatar':
                $data = array(
                    'type' => 'user',
                    'prefix' => 'a'
                );
                break;
            case 'profile':
                $data = array(
                    'type' => 'user',
                    'prefix' => 'p'
                );
                break;
            default:
                $data = array('type' => 'user');
        }
        return $this->get_media($id, $data);
    }

    //"/media/photo/thumb/$p->media;"
    public function photo($type, $id) {
        switch ($type) {
            case 'thumb':
                $data = array(
                    'type' => 'photo',
                    'prefix' => 't'
                );
                break;
            case 'cover':
                $data = array(
                    'type' => 'photo',
                    'prefix' => 'c'
                );
                break;
            default:
                $data = array('type' => 'photo');
        }
        return $this->get_media($id, $data);
    }

    private function get_media($id, $data = array()) {
        $media = $this->media_model->get_media($id);
        $patch = SERVERROOT . DS . 'upload' . DS .
                 implode(DS, str_split($media->file_hash, 2)) . DS;
        if ($data['type'] === 'user' || $data['type'] === 'photo') {
            if (empty($data['prefix'])) {
                $fName =  $media->file_hash . '.' . $media->file_ext;
            } else {
                $fName = $media->file_hash . '_' . $data['prefix'] . '.png';
                if (!file_exists($patch . $fName)) {
                    if ($data['prefix'] === 'a' || $data['prefix'] === 'p') {
                        $this->media_model->resize_avatar($media);
                    } elseif ($data['prefix'] === 't') {
                        $this->media_model->create_thumbs($media);
                    } elseif ($data['prefix'] === 'c') {
                        $this->media_model->create_cover($media);
                    }
                }
                $media->type = 'image/png';
            }
            if (file_exists($patch . $fName)) {
                $filePatch = $patch . $fName;
                $fileMime = $media->type;
            } else {

                $filePatch = SERVERROOT . DS . 'public'. DS .'assets' . DS . 'img' . DS . 'blank.jpeg';
                $fileMime = 'image/jpeg';
            }
            $this->_get_img($filePatch, $fileMime);
        }
    }

    private function _get_img($fName, $fMime) {
        if (ob_get_level()) {
                ob_end_clean();
            }
        header('Content-Type: '.$fMime);
        readfile($fName);
    }
//    private function _get_media() {
//        if (file_exists($file)) {
//            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
//            // если этого не сделать файл будет читаться в память полностью!
//            if (ob_get_level()) {
//                ob_end_clean();
//            }
//        header('Content-Type: image/gif');
//        readfile('path/to/myimage.gif');
//        }


}