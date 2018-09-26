<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class M_Kota extends CI_Model
  {
    public $id;
    public $provinsi_id;    
    public $name;

  	function __construct()
    {
      parent::__construct();
    }

    public function getAllData($offset = null, $limit = null){
        if($this->id != ""){
            $this->db->where(array("id"=>$this->id));
        }

        if($this->provinsi_id != ""){
            $this->db->where(array("provinsi_id"=>$this->provinsi_id));
        }

        if($this->name != ""){
            $this->db->where(array("name"=>$this->name));
        }

        $this->db->select('*');
        $this->db->order_by('name','asc');
        
        $this->db->limit($limit, $offset);

        $result = $this->db->get('kota');

        return $result;
    } 

    public function getKota($tipe, $key){
        switch ($tipe) {
            case "provinsi":
                $this->db->where(array("provinsi_id"=>$key));
                break;
        }
    	$this->db->select('*');
    	$result = $this->db->get('kota');
    	return $result;
    }


  }
?>