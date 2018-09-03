<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media_model extends CI_Model
{
    private $media_table = 'media';

    /**
     * Добавление записи/записей о медиафайлах в БД
     *
     * @param array $data массив с данными файла, либо многомерный массив с данными файлами
     * @param null|string $key используется только для многомерных массивов файлов
     *                         при указании удаляет из набора данных каждого файла
     *                         указанный ключ, делая его индексом в возвраащаемом массиве
     *
     * @return int|array|null если первый параметр не является массивом возвращается null
     *                        при единичном файле возвращается id записи, при добавлении
     *                        массива файлов возвращается массив $key => $id, где $id
     *                        id файла, а $key при наличи второго параметра это знкчение из
     *                        входных данных иначе индекс исходного массива
     */
    public function add_media($data, $key = null) {
        if (is_array($data) && !isAssoc($data)) {
            $ret = array();
            foreach ($data as $r_key => $row) {
                if (is_string($key)) {
                    $id = $row[$key];
                    unset($row[$key]);
                } else {
                    $id = $r_key;
                }
                $this->db->insert($this->media_table, $data);
                $ret[$id] = $this->db->insert_id();
            }
        } elseif (is_array($data) && array() !== $data) {
            $this->db->insert($this->media_table, $data);
            $ret = $this->db->insert_id();
        } else {
            $ret = null;
        }
        return $ret;
    }

    /**
     * Получаем данные о медиафайлах
     * @param int|array $id Int для единичного файла, или массив Int для группы файлов
     *
     * @return mixed|null возвращает null если входные данные не верны иначе возвращает CI_DB результат
     */
    public function get_media($id) {
        if (is_numeric($id)) {
            $ret = $this->db->get_where($this->media_table, '`id` = '.$id, 1)->row();
        } elseif (is_array($id)) {
            $ret = $this->db->where_in('id', $id)->get($this->media_table)->result();
        } else {
            $ret = null;
        }
        return $ret;
    }

    /**
     * @param null|string $url
     *
     * @return string
     */
    public function download_media($url = null) {
        $p_info = pathinfo(parse_url($url, PHP_URL_PATH)); // filename, extension
        $media = file_get_contents($url);
        $hash = sha1_file($url);
        $upl = SERVERROOT . DS . 'upload';
        if (!is_dir($upl)) {
            mkdir($upl, 0777, true);
        }
        $tmp_path =  $upl . DS . 'f' . $hash . '.file';
        file_put_contents($tmp_path, $media);
        $mime_types = mime_content_type($tmp_path);
        if (empty($p_info['extension'])) {
            switch ($mime_types) {
                case 'image/gif':
                    $ext = 'gif';
                    break;
                case 'image/jpeg':
                    $ext = 'jpg';
                    break;
                case 'image/png':
                    $ext = 'png';
                    break;
                default:
                    $ext = 'none';
            }
        } else {
            $ext = $p_info['extension'];
        }
        if ($c = $this->check_for_file($hash, $ext)) {
            if (file_exists($tmp_path)) {
                unlink($tmp_path);
            }
            return (int)$c;
        }
        $file_dir = $upl . DS . implode(DS, str_split($hash, 2));
        if (!is_dir($file_dir)) {
            mkdir($file_dir, 0777, true);
        }
        $file_name = $file_dir . DS . $hash . '.' . $ext;
        rename($tmp_path, $file_name);
        if (file_exists($tmp_path)) {
            unlink($tmp_path);
        }
        //Записать в бд
        $data = array(
            'type' => $mime_types,
            'file_hash' => $hash,
            'file_orig_name' => $p_info['filename'],
            'file_ext' => $ext,
        );
        return $this->add_media($data);
    }

    public function upload_media($url = null) {
        $p_info = pathinfo(parse_url($url, PHP_URL_PATH)); // filename, extension
        $media = file_get_contents($url);
        $hash = sha1_file($url);
        $upl = SERVERROOT . DS . 'upload';
        if (!is_dir($upl)) {
            mkdir($upl, 0777, true);
        }
        $tmp_path =  $upl . DS . 'f' . $hash . '.file';
        file_put_contents($tmp_path, $media);
        $mime_types = mime_content_type($tmp_path);
        //var_dump($mime_types); echo '<br>'; die();
        if (empty($p_info['extension'])) {
            switch ($mime_types) {
                case 'image/gif':
                    $ext = 'gif';
                    break;
                case 'image/jpeg':
                    $ext = 'jpg';
                    break;
                case 'image/png':
                    $ext = 'png';
                    break;
                default:
                    $ext = 'none';
            }
        } else {
            $ext = $p_info['extension'];
        }
        if ($c = $this->check_for_file($hash, $ext)) {
            return (int)$c;
        }
        $file_dir = $upl . DS . implode(DS, str_split($hash, 2));
        if (!is_dir($file_dir)) {
            mkdir($file_dir, 0777, true);
        }
        $file_name = $file_dir .DS . $hash . '.' . $ext;
        rename($tmp_path, $file_name);
        //Записать в бд
        $data = array(
            'type' => $mime_types,
            'file_hash' => $hash,
            'file_orig_name' => $p_info['filename'],
            'file_ext' => $ext,
        );
        return $this->add_media($data);
    }

    /**
     * Проверяем наличие файла в загруженных
     * @param string $hash sha1-хэш файла
     * @param string $ext  расширение файла
     *
     * @return int|false при наличии файла возвращает id из базы иначе false
     */
    public function check_for_file($hash, $ext) {
        $query = $this->db->select('id')
                      ->where(array('file_hash' => $hash, 'file_ext' => $ext))
                      ->get($this->media_table, 1);
        if (is_bool($query) !== true && $query->num_rows() === 1) {
            return $query->row()->id;
        } else {
            return false;
        }
    }

    public function resize_avatar($media) {
        $this->config->load('photos', TRUE);
        $fDir = SERVERROOT . DS . 'upload' . DS . implode(DS, str_split($media->file_hash, 2)). DS;
        $fName = $fDir . $media->file_hash . '.' . $media->file_ext;
        $aName = $fDir . $media->file_hash . '_a.png';
        $pName = $fDir . $media->file_hash . '_p.png';
        switch ($media->type) {
            case 'image/png':
                $im = imagecreatefrompng($fName);
                break;
            case 'image/gif':
                $im = imagecreatefromgif($fName);
                break;
            case 'image/jpeg':
            default:
                $im = imagecreatefromjpeg($fName);
                break;
        }
        // создаем аватар
        $a_s = $this->config->item('avatar_size', 'photos');
        $avatar = imagecreatetruecolor($a_s, $a_s);
        imagecopyresampled($avatar, $im,0,0,0,0, $a_s, $a_s, imagesx($im), imagesy($im));
        imagepng($avatar, $aName, 0);
        imagedestroy($avatar);
        // создаем фотографию на странице профиля
        $p_s = $this->config->item('photo_profile_size', 'photos');
        $photoProfile = imagecreatetruecolor($p_s, $p_s);
        imagecopyresampled($photoProfile, $im,0,0,0,0, $p_s, $p_s, imagesx($im), imagesy($im));
        imagepng($photoProfile, $pName, 0);
        imagedestroy($photoProfile);
        imagedestroy($im);
    }

    public function create_thumbs($media) {
        $this->config->load('photos', TRUE);
        $fDir = SERVERROOT . DS . 'upload' . DS . implode(DS, str_split($media->file_hash, 2)). DS;
        $fName = $fDir . $media->file_hash . '.' . $media->file_ext;
        $tName = $fDir . $media->file_hash . '_t.png';
        switch ($media->type) {
            case 'image/png':
                $im = imagecreatefrompng($fName);
                break;
            case 'image/gif':
                $im = imagecreatefromgif($fName);
                break;
            case 'image/jpeg':
            default:
                $im = imagecreatefromjpeg($fName);
                break;
        }
        // создаем превью
        $t_s = $this->config->item('thumb_size', 'photos');
        $thumb = imagecreatetruecolor($t_s['w'], $t_s['h']);
        imagecopyresampled($thumb, $im,0,0,0,0, $t_s['w'], $t_s['h'], imagesx($im), imagesy($im));
        imagepng($thumb, $tName, 0);
        imagedestroy($thumb);
        imagedestroy($im);
    }

    public function create_cover($media) {
        $this->config->load('photos', TRUE);
        $fDir = SERVERROOT . DS . 'upload' . DS . implode(DS, str_split($media->file_hash, 2)). DS;
        $fName = $fDir . $media->file_hash . '.' . $media->file_ext;
        $tName = $fDir . $media->file_hash . '_c.png';
        switch ($media->type) {
            case 'image/png':
                $im = imagecreatefrompng($fName);
                break;
            case 'image/gif':
                $im = imagecreatefromgif($fName);
                break;
            case 'image/jpeg':
            default:
                $im = imagecreatefromjpeg($fName);
                break;
        }
        // создаем превью
        $t_s = $this->config->item('cover_size', 'photos');
        $thumb = imagecreatetruecolor($t_s['w'], $t_s['h']);
        imagecopyresampled($thumb, $im,0,0,0,0, $t_s['w'], $t_s['h'], imagesx($im), imagesy($im));
        imagepng($thumb, $tName, 0);
        imagedestroy($thumb);
        imagedestroy($im);
    }
}