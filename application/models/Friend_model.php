<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:03
 */

class Friend_model extends CI_Model
{
    private $friend_table = 'friend';
    public function __construct() {
        $this->load->helper('array_helper');
    }

    public function get_friends($user_id, $online = false) {
        $where = ' AND fr.friend_status = \'confirmed\'';
        if ($online) {
            $where .= ' AND online = true';
        }
        $where1 = '(fr.friend_id = '.$user_id.')'.$where;
        $where2 = '(fr.user_id = '.$user_id.')'.$where;
        $fr1 = $this->db->select('fr.user_id as id, fr.date_add,
                concat(u.first_name," ",u.last_name) as full_name_user,
                u.avatar, um.online as online')
            ->from($this->friend_table.' as fr')
            ->join('user as u',
                   'u.id = fr.user_id',
                    'left')
            ->join('user_meta as um',
                   'um.id = fr.user_id',
                   'left')
            ->where($where1)->get()->result();
        $fr2 = $this->db->select('fr.friend_id as id, fr.date_add,
                concat(u.first_name," ",u.last_name) as full_name_user,
                u.avatar, um.online as online')
                 ->from($this->friend_table.' as fr')
                 ->join('user as u',
                        'u.id = fr.friend_id',
                        'left')
                 ->join('user_meta as um',
                        'um.id = fr.friend_id',
                        'left')
                 ->where($where2)->get()->result();
        $fr = array_merge($fr1, $fr2);
        usort($fr, build_sorter_arr_obj('date_add'));
        return $fr;
    }

    public function get_friends_request($user_id) {
        $where = 'fr.friend_id = '.$user_id.' AND fr.friend_status = \'request\'';
        return $this->db->select('fr.user_id as id, fr.date_add,
                concat(u.first_name," ",u.last_name) as full_name_user,
                u.avatar')
            ->from($this->friend_table.' as fr')
            ->join('user as u',
                   'u.id = fr.user_id',
                   'left')
            ->join('user_meta as um',
                   'um.id = fr.user_id',
                   'left')
            ->where($where)->get()->result();
    }

    public function get_user_request($user_id) {
        $where = 'fr.user_id = '.$user_id.' AND fr.friend_status = \'request\'';
        return $this->db->select('fr.friend_id as id, fr.date_add,
                concat(u.first_name," ",u.last_name) as full_name_user,
                u.avatar')
                        ->from($this->friend_table.' as fr')
                        ->join('user as u',
                               'u.id = fr.friend_id',
                               'left')
                        ->join('user_meta as um',
                               'um.id = fr.friend_id',
                               'left')
                        ->where($where)->get()->result();
    }

    public function get_blacklist($user_id) {
        $where = 'fr.user_id = '.$user_id.' AND fr.friend_status = \'blacklist\'';
        return $this->db->select('fr.friend_id as id, fr.date_add,
                concat(u.first_name," ",u.last_name) as full_name_user,
                u.avatar')
                        ->from($this->friend_table.' as fr')
                        ->join('user as u',
                               'u.id = fr.friend_id',
                               'left')
                        ->join('user_meta as um',
                               'um.id = fr.friend_id',
                               'left')
                        ->where($where)->get()->result();
    }

    public function add_friend($user_id, $friend_id) {
        $data = array(
            'user_id' => $user_id,
            'friend_id' => $friend_id,
        );

        return $this->db->insert($this->friend_table, $data);

    }

    /**
     * 'request','confirmed','subscriber','blacklist'
     */
    public function change_friend_status($user_id, $friend_id, $status) {
        $this->db->set('friend_status', $status);
        $this->db->where(array('user_id' => $user_id, 'friend_id' => $friend_id));

        $this->db->update($this->friend_table);
    }

    public function delete_friend($user_id, $friend_id) {
        return $this->db->delete($this->friend_table, array('user_id' => $user_id, 'friend_id' => $friend_id));
    }
}