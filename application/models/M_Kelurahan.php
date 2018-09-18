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

    public function getKelurahan($tipe, $key){
        switch ($tipe) {
            case "provinsi":
                $this->db->where(array("left(id,2)"=>$key));
                break;
            case "kota":
                $this->db->where(array("left(id,4)"=>$key));
                break;
            case "kecamatan":
                $this->db->where(array("left(id,6)"=>$key));
                break;
        }
    	$this->db->select('*');
    	$result = $this->db->get('kelurahan');
    	return $result;
    }

  }
?>