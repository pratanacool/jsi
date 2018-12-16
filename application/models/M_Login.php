<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class M_Login extends CI_Model
  {

    function __construct()
    {
      parent::__construct();
    }

    public function prosesAdmin($username, $password) {
      $where['username'] = $username;
      $where['password'] = md5($password);
      $this->db->select('*');
      $rs = $this->db->get_where('users', $where)->row();

      if ($rs) {
        $log["username"] = $rs->username;
        $log["role"] = $rs->role; 
        $this->session->set_userdata($log);
        return true;
      }

      else {
        return false;
      }
    }    

  }
?>