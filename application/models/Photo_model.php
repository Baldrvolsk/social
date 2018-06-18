<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 08.06.2018
 * Time: 14:03
 */

class Photo_model extends CI_Model
{

    public function __construct() {

    }

  public function download_photo($url = '', $user_id = 0)
  {
      if((int)$user_id != 0) {
          $tmp = explode('.',$url);
          $ext = end($tmp);
          $photo = file_get_contents($url);
          file_put_contents('uploads/profile/'.$user_id.'/active.'.$ext,$photo);
          return 'active.'.$ext;
      }
  }




}