<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class M_Kecamatan extends CI_Model
  {
    public $id;
    public $kota_id;
    public $name;
  	function __construct()
    {
      parent::__construct();
    }

    public function getAllData($offset = null, $limit = null){
        if($this->id != ""){
            $this->db->where(array("id"=>$this->id));
        }

        if($this->kota_id != ""){
            $this->db->where(array("kota_id"=>$this->kota_id));
        }

        if($this->name != ""){
            $this->db->where(array("name"=>$this->name));
        }

        $this->db->select('*');
        $this->db->order_by('name','asc');
        
        $this->db->limit($limit, $offset);

        $result = $this->db->get('kecamatan');

        return $result;
    } 

    public function getKecamatan($tipe, $key){
        switch ($tipe) {
            case "provinsi":
                $this->db->where(array("left(id,2)"=>$key));
                break;
            case "kota":
                $this->db->where(array("left(id,4)"=>$key));
                break;
        }
    	$this->db->select('*');
    	$result = $this->db->get('kecamatan');
    	return $result;
    }


  }
?>