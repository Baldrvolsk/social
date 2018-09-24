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
        $this->lang->load('profile');
    }

    public function get_people($user_id, $limit = 40, $offset = 0) {
        $where["user.id !="] = $user_id;
        return $this->db
            ->select('user.id as id, concat(user.first_name," ",user.last_name) as full_name_user,
                 user.avatar, f_u.friend_status as f_u_status, u_f.friend_status as u_f_status,
                 user_meta.online as online, u_g.group_id')
            ->from('user')
            ->join('friend as f_u',
                   '(f_u.user_id = user.id AND f_u.friend_id = ' . $user_id . ')',
                   'left')
            ->join('friend as u_f',
                   '(u_f.user_id = ' . $user_id . ' AND u_f.friend_id = user.id)',
                   'left')
            ->join('user_group as u_g',
                   'u_g.user_id = user.id',
                   'left')
            ->join('user_meta',
                   'user_meta.id = user.id',
                   'left')
            ->where($where)
            ->limit($limit, $offset)
            ->get()->result();
    }

    public function get_friends($user_id) {
        $where = ' AND fr.friend_status = \'confirmed\'';
        $where1 = '(fr.friend_id = ' . $user_id . ')' . $where;
        $where2 = '(fr.user_id = ' . $user_id . ')' . $where;
        $fr1 = $this->db->select('fr.user_id as id, fr.date_add,
                concat(u.first_name," ",u.last_name) as full_name_user,
                f_u.friend_status as f_u_status, u_f.friend_status as u_f_status,
                u.avatar, um.online as online, u_g.group_id')
                        ->from($this->friend_table . ' as fr')
                        ->join('user as u',
                               'u.id = fr.user_id',
                               'left')
                        ->join('friend as f_u',
                               '(f_u.user_id = u.id AND f_u.friend_id = ' . $user_id . ')',
                               'left')
                        ->join('friend as u_f',
                               '(u_f.user_id = ' . $user_id . ' AND u_f.friend_id = u.id)',
                               'left')
                        ->join('user_group as u_g',
                               'u_g.user_id = u.id',
                               'left')
                        ->join('user_meta as um',
                               'um.id = fr.user_id',
                               'left')
                        ->where($where1)->get()->result();
        $fr2 = $this->db->select('fr.friend_id as id, fr.date_add,
                concat(u.first_name," ",u.last_name) as full_name_user,
                f_u.friend_status as f_u_status, u_f.friend_status as u_f_status,
                u.avatar, um.online as online, u_g.group_id')
                        ->from($this->friend_table . ' as fr')
                        ->join('user as u',
                               'u.id = fr.friend_id',
                               'left')
                        ->join('friend as f_u',
                               '(f_u.user_id = u.id AND f_u.friend_id = ' . $user_id . ')',
                               'left')
                        ->join('friend as u_f',
                               '(u_f.user_id = ' . $user_id . ' AND u_f.friend_id = u.id)',
                               'left')
                        ->join('user_group as u_g',
                               'u_g.user_id = u.id',
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
        $where = 'f_u.friend_id = ' . $user_id . ' AND f_u.friend_status = \'request\'';
        return $this->db->select('user.id as id, concat(user.first_name," ",user.last_name) as full_name_user,
                 user.avatar, f_u.friend_status as f_u_status, u_f.friend_status as u_f_status,
                 user_meta.online as online, u_g.group_id')
                        ->from('user')
                        ->join('friend as f_u',
                               '(f_u.user_id = user.id AND f_u.friend_id = ' . $user_id . ')',
                               'left')
                        ->join('friend as u_f',
                               '(u_f.user_id = ' . $user_id . ' AND u_f.friend_id = user.id)',
                               'left')
                        ->join('user_group as u_g',
                               'u_g.user_id = user.id',
                               'left')
                        ->join('user_meta',
                               'user_meta.id = user.id',
                               'left')
                        ->where($where)->get()->result();
    }

    public function get_user_request($user_id) {
        $where = 'u_f.user_id = ' . $user_id . ' AND u_f.friend_status = \'request\'';
        return $this->db->select('user.id as id, concat(user.first_name," ",user.last_name) as full_name_user,
                 user.avatar, f_u.friend_status as f_u_status, u_f.friend_status as u_f_status,
                 user_meta.online as online, u_g.group_id')
                        ->from('user')
                        ->join('friend as f_u',
                               '(f_u.user_id = user.id AND f_u.friend_id = ' . $user_id . ')',
                               'left')
                        ->join('friend as u_f',
                               '(u_f.user_id = ' . $user_id . ' AND u_f.friend_id = user.id)',
                               'left')
                        ->join('user_group as u_g',
                               'u_g.user_id = user.id',
                               'left')
                        ->join('user_meta',
                               'user_meta.id = user.id',
                               'left')
                        ->where($where)->get()->result();
    }

    public function get_user_subscriber($user_id) {
        $where = 'f_u.user_id = ' . $user_id . ' AND f_u.friend_status = \'subscriber\'';
        return $this->db->select('user.id as id, concat(user.first_name," ",user.last_name) as full_name_user,
                 user.avatar, f_u.friend_status as f_u_status, u_f.friend_status as u_f_status,
                 user_meta.online as online, u_g.group_id')
                        ->from('user')
                        ->join('friend as f_u',
                               '(f_u.user_id = user.id AND f_u.friend_id = ' . $user_id . ')',
                               'left')
                        ->join('friend as u_f',
                               '(u_f.user_id = ' . $user_id . ' AND u_f.friend_id = user.id)',
                               'left')
                        ->join('user_group as u_g',
                               'u_g.user_id = user.id',
                               'left')
                        ->join('user_meta',
                               'user_meta.id = user.id',
                               'left')
                        ->where($where)->get()->result();
    }

    public function get_blacklist($user_id) {
        $where = 'u_f.user_id = ' . $user_id . ' AND u_f.friend_status = \'blacklist\'';
        return $this->db->select('user.id as id, concat(user.first_name," ",user.last_name) as full_name_user,
                 user.avatar, f_u.friend_status as f_u_status, u_f.friend_status as u_f_status,
                 user_meta.online as online, u_g.group_id')
                        ->from('user')
                        ->join('friend as f_u',
                               '(f_u.user_id = user.id AND f_u.friend_id = ' . $user_id . ')',
                               'left')
                        ->join('friend as u_f',
                               '(u_f.user_id = ' . $user_id . ' AND u_f.friend_id = user.id)',
                               'left')
                        ->join('user_group as u_g',
                               'u_g.user_id = user.id',
                               'left')
                        ->join('user_meta',
                               'user_meta.id = user.id',
                               'left')
                        ->where($where)->get()->result();
    }

    /**
     * Функция смены статуса друзей
     *
     * @param int    $user_id
     * @param int    $friend_id
     * @param string $status in list request, confirmed, subscriber, blacklist, delete
     *
     * @return mixed
     */
    public function change_friend_status($user_id, $friend_id, $status) {
        $uf_query = $this->db->select('friend_status')
                             ->from($this->friend_table)
                             ->where('user_id', $user_id)->where('friend_id', $friend_id)
                             ->limit(1)->get()->row();
        $fu_query = $this->db->select('friend_status')
                             ->from($this->friend_table)
                             ->where('friend_id', $user_id)->where('user_id', $friend_id)
                             ->limit(1)->get()->row();
        $ret = array();
        switch ($status) {
            case 'request':
                if (!$uf_query && !$fu_query && $this->add_friend($user_id, $friend_id)) {
                    $ret['status'] = "OK";
                    $ret['message'] = 'Запрос на добавление в друзья успешно отправлен';
                } elseif ($uf_query->friend_status === 'blacklist') {
                    $this->db->set('friend_status', $status);
                    $this->db->where(array('user_id' => $user_id, 'friend_id' => $friend_id));
                    $this->db->update($this->friend_table);
                    $ret['status'] = "OK";
                    $ret['message'] = 'Вы удалили пользователя из черного списка и отправили ему запрос в друзья';
                } else {
                    $ret['status'] = "ERR";
                    $ret['message'] = 'Что-то пошло не так, попробуйте позже';
                    if (DEBUG) $ret['error'] = 'неудачная запись в БД';
                }
                break;
            case 'confirmed':
                if (!$fu_query) {
                    $ret['status'] = "ERR";
                    $ret['message'] = 'Что-то пошло не так, попробуйте позже';
                    if (DEBUG) $ret['error'] = 'пользователь не создавал запрос на добавление в друзья';
                } elseif ($fu_query->friend_status === 'request') {
                    $this->db->set('friend_status', $status);
                    $this->db->where(array('user_id' => $friend_id, 'friend_id' => $user_id));
                    $this->db->update($this->friend_table);
                    $ret['status'] = "OK";
                    $ret['message'] = 'Вы подтвердили добавление в друзья';
                }
                break;
            case 'subscriber':
                if (!$fu_query) {
                    $ret['status'] = "ERR";
                    $ret['message'] = 'Что-то пошло не так, попробуйте позже';
                    if (DEBUG) $ret['error'] = 'пользователь не может стать вашим подписчиком';
                } elseif ($fu_query->friend_status === 'request' || $fu_query->friend_status === 'confirmed') {
                    $this->db->set('friend_status', $status);
                    $this->db->where(array('user_id' => $friend_id, 'friend_id' => $user_id));
                    $this->db->update($this->friend_table);
                    $ret['status'] = "OK";
                    $ret['message'] = 'Вы оставили пользователя в подписчиках';
                }
                break;
            case 'blacklist':
                if (!$uf_query && !$fu_query) {
                    $data = array(
                        'user_id'       => $user_id,
                        'friend_id'     => $friend_id,
                        'friend_status' => 'blacklist',
                    );
                    $this->db->insert($this->friend_table, $data);
                    $ret['status'] = "OK";
                    $ret['message'] = 'Пользователь добавлен в черный список';
                } elseif ($uf_query) {
                    $this->db->set('friend_status', 'blacklist');
                    $this->db->where(array('user_id' => $user_id, 'friend_id' => $friend_id));
                    $this->db->update($this->friend_table);
                    $ret['status'] = "OK";
                    $ret['message'] = 'Пользователь добавлен в черный список';
                } elseif ($fu_query) {
                    $this->db->delete($this->friend_table, array('user_id' => $user_id, 'friend_id' => $friend_id));
                    $this->db->set('friend_status', 'blacklist');
                    $this->db->where(array('user_id' => $user_id, 'friend_id' => $friend_id));
                    $this->db->update($this->friend_table);
                    $ret['status'] = "OK";
                    $ret['message'] = 'Пользователь добавлен в черный список';
                }
                break;
            case 'delete':
                if (!$uf_query && !$fu_query) {
                    $ret['status'] = "ERR";
                    $ret['message'] = 'Что-то пошло не так, попробуйте позже';
                } elseif ($uf_query) {
                    $this->delete_friend($user_id, $friend_id);
                    $ret['status'] = "OK";
                    $ret['message'] = 'Вы удалили себя из списка друзей';
                } elseif ($fu_query) {
                    $this->delete_friend($friend_id, $user_id);
                    $ret['status'] = "OK";
                    $ret['message'] = 'Вы удалили пользователя из списка друзей';
                }
                break;
        }
        $ret['html'] = $this->theme->view('user/people_item',
                                          array('row' => $this->get_one_people($user_id, $friend_id), 'full' => false),
                                          true);
        return $ret;
    }

    public function add_friend($user_id, $friend_id) {
        $data = array(
            'user_id'       => $user_id,
            'friend_id'     => $friend_id,
            'friend_status' => 'request',
        );
        return $this->db->insert($this->friend_table, $data);
    }

    public function delete_friend($user_id, $friend_id) {
        return $this->db->delete($this->friend_table, array('user_id' => $user_id, 'friend_id' => $friend_id));
    }

    public function get_one_people($user_id, $friend_id) {
        return $this->db
            ->select('user.id as id, concat(user.first_name," ",user.last_name) as full_name_user,
                 user.avatar, f_u.friend_status as f_u_status, u_f.friend_status as u_f_status,
                 user_meta.online as online, u_g.group_id')
            ->from('user')
            ->join('friend as f_u',
                   '(f_u.user_id = user.id AND f_u.friend_id = ' . $user_id . ')',
                   'left')
            ->join('friend as u_f',
                   '(u_f.user_id = ' . $user_id . ' AND u_f.friend_id = user.id)',
                   'left')
            ->join('user_group as u_g',
                   'u_g.user_id = user.id',
                   'left')
            ->join('user_meta',
                   'user_meta.id = user.id',
                   'left')
            ->where('user.id', $friend_id)
            ->limit(1)
            ->get()->row();
    }
}