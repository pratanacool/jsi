<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class M_Interview_master extends CI_Model
  {
    public $id;
    public $caleg_id;
    public $pemilih_id;
    public $waktu;
    public $user_id;
    public $memilih;
    public $banyak_pemilih;
    public $kontak;

  	function __construct()
    {
      parent::__construct();
    }

    public function simpan(){
      $data['caleg_id'] = $this->caleg_id;
      $data['pemilih_id'] = $this->pemilih_id;
      $data['user_id'] = $this->user_id;
      $data['memilih'] = $this->memilih;
      $data['banyak_pemilih'] = $this->banyak_pemilih;
      $data['kontak'] = $this->kontak;

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

    public function viewInterview(){
      $this->db->select("m.waktu, d.pertanyaan, d.jawaban");
      $this->db->join("d_interview d","m.id = d.m_interview_id", "left");       
      $this->db->where("caleg_id", $this->caleg_id);
      $this->db->where("pemilih_id", $this->pemilih_id);
      $data = $this->db->get("m_interview m");
      return $data->result();
    }     

  }
?>