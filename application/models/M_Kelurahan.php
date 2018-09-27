<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class M_Kelurahan extends CI_Model
  {
    public $id;
    public $kecamatan_id;
    public $name;
  	function __construct()
    {
      parent::__construct();
    }

    public function getTotalData(){
        if($this->id != ""){
            $this->db->where(array("id"=>$this->id));
        }

        if($this->kecamatan_id != ""){
            $this->db->where(array("kecamatan_id"=>$this->kecamatan_id));
        }

        if($this->name != ""){
            $this->db->where(array("name"=>$this->name));
        }

        $this->db->select('count(*) as total');
        $result = $this->db->get('kelurahan');

        return $result->row()->total;
    } 

    public function getAllData($offset = null, $limit = null){
        if($this->id != ""){
            $this->db->where(array("id"=>$this->id));
        }

        if($this->kecamatan_id != ""){
            $this->db->where(array("kecamatan_id"=>$this->kecamatan_id));
        }

        if($this->name != ""){
            $this->db->where(array("name"=>$this->name));
        }

        $this->db->select('*');
        $this->db->order_by('name','asc');
        
        $this->db->limit($limit, $offset);

        $result = $this->db->get('kelurahan');

        return $result;
    } 

    public function getKelurahan($tipe, $key){
        switch ($tipe) {
            case "provinsi":
                $this->db->where(array("left(id,2)"=>$key));
                break;
            case "kota":
                $this->db->where(array("left(id,4)"=>$key));
                break;
            case "kecamatan":
                $this->db->where(array("left(id,7)"=>$key));
                break;
        }
    	$this->db->select('*');
    	$result = $this->db->get('kelurahan');
    	return $result;
    }

  }
?>