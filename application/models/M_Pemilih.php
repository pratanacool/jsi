<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class M_Pemilih extends CI_Model{
    public $id;
    public $nik;
    public $nama;
    public $tempatLahir;
    public $tanggalLahir;
    public $gender;
    public $provinsi;
    public $kota;
    public $kecamatan;
    public $kelurahan;
    public $tps;

    function __construct(){
      parent::__construct();
    }
    
    public function getAllData($offset = null, $limit = null){
      
      if( $this->provinsi != null ){
        $this->db->where(array("provinsi" => $this->provinsi));
      } 

      if( $this->kota != null ){
        $this->db->where(array("kota" => $this->kota));
      }

      if( $this->kecamatan != null ){
        $this->db->where(array("kecamatan" => $this->kecamatan));
      }

      if( $this->kelurahan != null ){
        $this->db->where(array("kelurahan" => $this->kelurahan));
      }

      if( $this->tps != null ){
        $this->db->where(array("tps" => $this->tps));
      }

      $this->db->select(
        "pemilih.*"
      );
      $this->db->from("pemilih");
      $this->db->order_by("pemilih.tps","asc");
      $this->db->order_by("pemilih.nama","asc");
      $this->db->limit($limit, $offset);
      $result = $this->db->get();
      return $result;

    }

    public function getTps($type, $key){
      switch ($type) {
        case "provinsi":
          $this->db->where(array("provinsi" => $key));
          break;
        
        case "kota":
          $this->db->where(array("kota" => $key));
          break;

        case "kecamatan":
          $this->db->where(array("kecamatan" => $key));
          break;

        case "kelurahan":
          $this->db->where(array("kelurahan" => $key));
          break;

      }
      $this->db->select('distinct(tps)');
      $this->db->from("pemilih");
      $this->db->order_by("tps","asc");
      $result = $this->db->get();
      return $result;      
    }

    public function getPemilih($type, $key){
      switch ($type) {
        case "provinsi":
          $this->db->where(array("provinsi" => $key));
          break;
        
        case "kota":
          $this->db->where(array("kota" => $key));
          break;

        case "kecamatan":
          $this->db->where(array("kecamatan" => $key));
          break;

        case "kelurahan":
          $this->db->where(array("kelurahan" => $key));
          break;

      }
      $this->db->select('*');
      $this->db->from("pemilih");
      $this->db->order_by("nama","asc");
      $result = $this->db->get();
      return $result; 
    }

    public function save(){
      $data = array();

      if(isset($this->nik)){
        $data['nik'] = $this->nik;
      }

      if(isset($this->nama)){
        $data['nama'] = $this->nama;
      }      

      if(isset($this->tempatLahir)){
        $data['tempat_lahir'] = $this->tempatLahir;
      }      

      if(isset($this->tanggalLahir)){
        $data['tanggal_lahir'] = $this->tanggalLahir;
      }      

      if(isset($this->gender)){
        $data['gender'] = $this->gender;
      }      
      else {
        $data['gender'] = "L";
      }

      if(isset($this->provinsi)){
        $data['provinsi'] = $this->provinsi;
      }

      if(isset($this->kota)){
        $data['kota'] = $this->kota;
      }

      if(isset($this->kecamatan)){
        $data['kecamatan'] = $this->kecamatan;
      }

      if(isset($this->kelurahan)){
        $data['kelurahan'] = $this->kelurahan;
      }

      if(isset($this->tps)){
        $data['tps'] = $this->tps;
      }

      if(isset($this->id)){
        $this->db->update('pemilih', $data, array('id'=>$this->id));
      }
      else {
        $this->db->insert('pemilih',$data);
        // $this->id = $this->db->insert_id();
      }

      return true;
    }

  }

?>