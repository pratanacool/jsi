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
        $result = $this->db->get('provinsi');

      return $result;
    }     

    public function getTotalData($offset = null, $limit = null){
    	$this->db->select('count(*) as total');
      $result = $this->db->get('provinsi');
    	return $result->row()->total;
    } 

  }
?>