<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class M_Interview_detail extends CI_Model
  {
    public $id;
    public $m_interview_id;
    public $pertanyaan;
    public $jawaban;

  	function __construct()
    {
      parent::__construct();
    }

    public function simpan(){
      $data['m_interview_id'] = $this->m_interview_id;
      $data['pertanyaan'] = $this->pertanyaan;
      $data['jawaban'] = $this->jawaban;

      // if ($this->id != "") {
      //   $where['id'] = $this->id;
      //   $this->db->update("d_interview",$data, $where);     
      // } 
      // else {
        $this->db->insert("d_interview",$data);
        // $this->id = $this->db->insert_id();  
      // }
      
      
      return true;
    }   

    public function hapus(){
      $where['m_interview_id'] = $this->m_interview_id;
      $this->db->delete("d_interview", $where);     
      return true;
    }   

  }
?>