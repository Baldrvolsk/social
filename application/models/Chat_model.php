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
    public function add_message($chat_id = 0)
    {
        if($this->input->post('content') != '')
        {
            $data['content'] = $this->input->post('content');
            if($chat_id == 0)
            {
                $data['chat_id'] = (int)$this->input->post('chat_id');
            } else {
                $data['chat_id'] = $chat_id;
            }
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

    /**
     * Ищет чат
     * если не находит то создает, и вставляет в него новую мессагу
     * @param int $user_id
     */
    public function find_chat($user_id = 0)
    {
        $sender = $this->user->id;
        $where = "(from=$user_id AND to = $sender) OR (from=$sender AND to=$user_id)";
        $this->db->where($where);
        $chat_id = $this->db->get($this->chat_table)->row();
        if(count($chat_id) > 0) {
            $this->add_message($chat_id->id);
        } else {
            $chat_id = $this->create_chat($sender,$user_id);
            $this->add_message($chat_id);
        }
    }

    /**
     * Создает чат если его не существует
     * @param int $sender_id
     * @param int $user_id
     * @return mixed
     */
    public function create_chat($sender_id = 0, $user_id = 0)
    {
        $data['from'] = $sender_id;
        $data['to'] = $user_id;
        $data['date_create'] = date('Y-m-d H:i:s');
        $this->db->insert($this->chat_table,$data);
        return $this->db->insert_id();
    }





}