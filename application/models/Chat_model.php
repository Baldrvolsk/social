<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:03
 */

class Chat_model extends CI_Model
{
    private $chat_table = 'chat';
    private $message_table = 'chat_message';
    public function __construct() {

    }

    /**
     * @return mixed
     */
    public function get_user_chats()
    {
        $q = 'SELECT c.*,concat(f.first_name," ",f.last_name) as from_user ,concat(t.first_name," ", t.last_name) as to_user FROM `chat` c LEFT JOIN users f ON f.id = c.from LEFT JOIN users t ON t.id = c.to';
        // Берет чаты, и подтягивает имена пользователей для отправителя и получателя
        return $this->db->query($q)->result();
    }

    /**
     * Возвращает сообщения в диалоге
     * @param int $id
     * @return mixed
     */
    public function get_chat($id = 0)
    {
        $this->db->select('chat_message.*,users.first_name,users.last_name');
        $this->db->from($this->message_table);
        $this->db->join('users','users.id=chat_message.user_id','LEFT');
        $this->db->where('chat_message.chat_id',(int)$id);

        return $this->db->get()->result();
    }

    /**
     *
     */
    public function add_message()
    {
        if($this->input->post('content') != '')
        {
            $data['content'] = $this->input->post('content');
            $data['chat_id'] = (int)$this->input->post('chat_id');
            $data['user_id'] = $this->user->id;
            $this->db->insert($this->message_table,$data);
        }
        return;
    }

    /**
     * Проверяет может ли юзер просмотреть диалог
     * @param int $id
     * @return bool
     */
    public function check_user_chat($id = 0)
    {
        $user_id = $this->user->id;
        $where = "id=$id AND (from=$user_id OR to = $user_id)";
        $this->db->where($where);

        $result = false;
        $query = $this->db->get($this->chat_table);
        if($query->num_rows() > 0)
        {
            $result = true;
        }
        return $result;
    }



}