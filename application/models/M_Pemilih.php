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
    public $memilih;
    public $pilihan;

    function __construct(){
      parent::__construct();
    }
    
    public function getAllData($offset = null, $limit = null, $search = null){
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

      if( $search != null ){
        $this->db->where("nama like '%".$search."%' or nik like '%".$search."%'");
      }

      if( $this->memilih != null ){
        $this->db->where("caleg_id", $this->memilih);
      }      

      if( $this->pilihan != '0' ){
        $this->db->where("m_interview.memilih", $this->pilihan);
      }

      $this->db->select(
        "pemilih.*, kelurahan.name as nama_kelurahan, m_interview.memilih, m_interview.banyak_pemilih, m_interview.kontak"
      );
      $this->db->from("pemilih");
      $this->db->join("m_interview","m_interview.pemilih_id = pemilih.id", "left");
      $this->db->join("kelurahan","kelurahan.id = pemilih.kelurahan","left");

      $this->db->order_by("pemilih.tps","asc");
      $this->db->order_by("pemilih.nama","asc");
      $this->db->limit($limit, $offset);
      $result = $this->db->get();
      return $result;
    }

    public function getTotalData($search = null){
      
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

      if( $search != null ){
        $this->db->where("nama like '%".$search."%' or nik like '%".$search."%'");
      }

      if( $this->memilih != null ){
        $this->db->where("caleg_id", $this->memilih);
      }

      if( $this->pilihan != '0' ){
        $this->db->where("m_interview.memilih", $this->pilihan);
      }

      $this->db->select(
        "count(*) as total"
      );
      $this->db->from("pemilih");
      $this->db->join("m_interview","m_interview.pemilih_id = pemilih.id", "left");
      $result = $this->db->get();
      return $result->row()->total;  
    }

    public function getAllDataTps($type, $key, $offset, $limit){
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
      $this->db->select('distinct(tps) as id, kelurahan');
      $this->db->from("pemilih");
      $this->db->limit($limit, $offset);
      $result = $this->db->get();
      return $result;      
    }

    public function getTotalDataTps($type, $key){
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
      $this->db->select('count(distinct(tps)) as total');
      $this->db->from("pemilih");
      $result = $this->db->get();
      return $result->row()->total;      
    }

    public function getPemilih($type, $key, $key2 = null){
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

        case "tps":
          $this->db->where(array("tps" => $key, "kelurahan" => $key2));
          break;

      }
      $this->db->select('count(*) as total');
      $this->db->from("pemilih");
      $result = $this->db->get();
      return $result->row()->total; 
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

      if(isset($this->memilih)){
        $data['memilih'] = $this->memilih;
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

    public function getTotalDataPemilih(){
      
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

      if( $this->memilih != null ){
        $this->db->where("caleg_id", $this->memilih);
      }

      if( $this->pilihan != '0' ){
        $this->db->where("m_interview.memilih", $this->pilihan);
      }

      $this->db->select(
        "sum(m_interview.banyak_pemilih) as total"
      );
      $this->db->from("pemilih");
      $this->db->join("m_interview","m_interview.pemilih_id = pemilih.id", "left");
      $result = $this->db->get();
      return $result->row()->total;  
    }


  }

?>