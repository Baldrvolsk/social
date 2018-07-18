<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:03
 */

class Group_post_model extends CI_Model
{
    private $post_table = 'community_post';
    public function __construct() {
        $this->load->model('like_model');
        $this->like_model->set_type('community_post');
    }

    public function get_post($id = null) {
        if ($id === null) {
            return;
        }

        $this->db->select('post.*, concat(users.first_name," ",users.last_name) as full_name_user, users.company as photo, post_like.like as u_like, (post.like - post.dislike) as delta')
                 ->from($this->post_table.' as post')
                 ->join('users','users.id = post.user_create_id','LEFT')
                 ->join('community_post_like as post_like','post_like.post_id = post.id AND post_like.user_id = '
                                              .$this->user->id,'LEFT')
                 ->where('post.id', (int)$id)
                 ->limit(1);
        return $this->db->get()->row();
    }
    public function get_group_post($group_id, $limit = null, $offset = null) {
        if ($limit !== null && $limit !== 0) {
            if ($offset === null) $offset = 0;
            $this->db->limit($limit, $offset);
        }
        $this->db->select('post.*, concat(users.first_name," ",users.last_name) as full_name_user, users.company as photo, post_like.like as u_like, (post.like - post.dislike) as delta')
                 ->from($this->post_table.' as post')
                 ->join('users','users.id = post.user_create_id','LEFT')
                 ->join('community_post_like as post_like','post_like.post_id = post.id AND post_like.user_id = '.$this->user->id,'LEFT')
                 ->order_by('post.date_add', 'desc')
                 ->where('post.group_id', (int)$group_id);
        return $this->db->get()->result();
    }

    public function create_post($data) {
        $link = null;
        $tags = null;
        $data_def = array(
            'link' => $link,
            'tags' => $tags,
            'views' => 0,
            'like' => 0,
            'dislike' => 0,
            'comments' => 0,
            'repost' => 0,
            'no_comm' => 0,
        );
        $all_data = array_merge($data, $data_def);
        return $this->db->insert($this->post_table, $all_data);
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