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