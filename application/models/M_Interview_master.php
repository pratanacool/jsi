<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class M_Interview_master extends CI_Model
  {
    public $id;
    public $caleg_id;
    public $pemilih_id;
    public $waktu;
    public $user_id;
    public $memilih;

  	function __construct()
    {
      parent::__construct();
    }

    public function simpan(){
      $data['caleg_id'] = $this->caleg_id;
      $data['pemilih_id'] = $this->pemilih_id;
      $data['user_id'] = $this->user_id;
      $data['memilih'] = $this->memilih;

      if ($this->id != "") {
        $where['id'] = $this->id;
        $this->db->update("m_interview",$data, $where);     
      } 
      else {
        $data['waktu'] = date("Y-m-d H:i:s");
        $this->db->insert("m_interview", $data);
        $this->id = $this->db->insert_id();  
      }
      
      
      return true;
    }     

  }
?>