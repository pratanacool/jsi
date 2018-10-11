<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class M_Provinsi extends CI_Model
  {
    public $id;
    public $name;
  	function __construct()
    {
      parent::__construct();
    }

    public function getProvinsi($offset = null, $limit = null){
      $this->db->select('*');
        $this->db->order_by('name','asc');
        $this->db->limit($limit, $offset);
        if ($this->id !="") {
          $this->db->where("id", $this->id);
        }
        $result = $this->db->get('provinsi');

      return $result;
    }     

    public function getTotalData($offset = null, $limit = null){
    	$this->db->select('count(*) as total');
      $result = $this->db->get('provinsi');
    	return $result->row()->total;
    } 

    public function getData(){
      if($this->id != ""){
        $this->db->where("id", $this->id);
      }

      if($this->name != ""){
        $this->db->like("name", $this->name);
      }

      $data = $this->db->get("provinsi")->row();
      $this->name = $data->name;
      return true;

    }

  }
?>