<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class M_Pemilih extends CI_Model
  {
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

    function __construct()
    {
      parent::__construct();
    }
    
    public function getAllData($offset = null, $limit = null)
    {
      
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
      $this->db->order_by("pemilih.nama","asc");
      $this->db->limit($limit, $offset);
      $result = $this->db->get();
      return $result;

    }
  }

?>