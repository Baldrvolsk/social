<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:03
 */

class Post_model extends CI_Model
{
    private $type;
    private $post_table;

    public function __construct() {
        //$this->load->model('like_model');
    }

    public function init($type) {
        $this->type = $type;
        $this->post_table = $this->type.'_post';
        //$this->like_model->set_type('user_post');
    }

    public function create_post() {
        $data = array(
            $this->type.'_id' => (int)$this->input->post('owner_id'),
            'user_create_id' => (int)$this->input->post('add_id'),
            'post_content' => $this->input->post('content', true),
            'media_type' => null,
            'media' => null,
            'tags' => null,
            'c_views' => 0,
            'c_like' => 0,
            'c_dislike' => 0,
            'c_comment' => 0,
            'c_shared' => 0,
        );
        if ($this->db->insert($this->post_table, $data)) {
            $id_post = $this->db->insert_id();
            $ret['post'] = $this->get_post($id_post);
            $ret['status'] = "OK";
            $ret['message'] = 'ост успешно добавлен';
        } else {
            $ret['status'] = "ERR";
            $ret['message'] = 'Что-то пошло не так, попробуйте позже';
            if (DEBUG) $ret['error'] = 'Ошибка записи в БД: '.$this->db->error();
        }
        return $ret;
    }

    public function get_post($id = null) {
        if ($id === null) return null;
        $this->db->select('post.*, concat(user.first_name," ",user.last_name) as full_name_user, '
                          .'user.avatar')
                 ->from($this->post_table.' as post')
                 ->join('user','user.id = post.user_create_id','LEFT')
                 ->where('post.id', (int)$id)
                 ->limit(1);
        return $this->db->get()->row();
    }

    public function get_users_post($user_id, $limit = 10, $offset = 0) {
        $user_id = isset($user_id) ? $user_id : $this->session->userdata('user_id');

        $this->db->select('`post`.*, concat(`user`.`first_name`," ",`user`.`last_name`) as `full_name_user`, '
            .'`user`.`avatar`, `post_like`.`like` as `u_like`, (`post`.`c_like` - `post`.`c_dislike`) as `delta`, '
            .'user_group.group_id as user_group')
            ->from($this->post_table.' as `post`')
            ->join('`user`','`user`.`id` = `post`.`user_create_id`','LEFT')
            ->join('`user_group`','`user_group`.`user_id` = `post`.`user_create_id`','LEFT')
            ->join($this->type.'_post_like as `post_like`',
                   '`post_like`.`post_id` = `post`.`id` AND `post_like`.`user_id` = '.$user_id,'LEFT')
            ->limit($limit, $offset)
            ->order_by('`post`.`date_add`', 'desc')
            ->where('`post`.`user_id`', (int)$user_id);
        $post = $this->db->get()->result();
        return $post;
    }



    public function update_post($id, $data) {
        $this->db->update($this->post_table, $data, array('id' => $id));
    }

    public function add_update_like($type, $post_id, $user_id) {
        switch ($type) {
            case 'up':
                $n_type = 1;
                break;
            case 'down':
                $n_type = 0;
                break;
            default:
                $n_type = 0;
        }
        $post = $this->get_post($post_id);
        $p_user = $this->ion_auth->get_meta($post->user_create_id);

        $like = $this->like_model->get_like($post_id, $user_id);
        if (empty($like)) {
            $this->like_model->set_like($post_id, $user_id, $n_type);
            if ($n_type === 1) {
                $p_data = array('like' => $post->like + 1);
                $u_data = ($p_user)?
                    array('all_like' => $p_user->all_like + 1):
                    array('all_like' => 1);
            } else {
                $p_data = array('dislike' => $post->dislike + 1);
                $u_data = ($p_user)?
                    array('all_dislike' => $p_user->all_dislike + 1):
                    array('all_dislike' => 1);
            }
            $u_data['count_day_like'] = ($p_user)?$p_user->count_day_like+1:1;
            $this->update_post($post_id, $p_data);
            $this->ion_auth->set_meta($user_id, $u_data);

        } else {
            $this->like_model->set_like($post_id, $user_id, $n_type);
            if ($n_type === 1) {
                $p_data = array('like' => $post->like + 1, 'dislike' => ($post->dislike - 1 < 0)?0:$post->dislike - 1, );
                $u_data = array('all_like' => $p_user->all_like + 1, 'all_dislike' => $p_user->all_dislike - 1);
            } else {
                $p_data = array('like' => ($post->like - 1 < 0)?0:$post->like - 1, 'dislike' => $post->dislike + 1, );
                $u_data = array('all_like' => $p_user->all_like - 1, 'all_dislike' => $p_user->all_dislike + 1);
            }
            $this->update_post($post_id, $p_data);
            $this->ion_auth->set_meta($user_id, $u_data);
        }
        return $this->get_post($post_id);

    }
}