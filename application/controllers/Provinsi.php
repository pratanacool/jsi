<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Provinsi extends MY_Controller{
    function __construct(){
      parent ::__construct();
      $this->load->library('pagination');
    }

    public function index(){
      $this->load->model('M_Provinsi', 'provinsi', true);
      $this->load->model('M_Kota', 'kota', true);
      $this->load->model('M_Kecamatan', 'kecamatan', true);
      $this->load->model('M_Kelurahan', 'kelurahan', true);
      $this->load->model('M_Pemilih','pemilih',true);
      $dataProvinsi = array();
      
      $limit = 10;      
      $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

      $config['per_page'] = $limit;      
      $config['base_url'] = base_url('provinsi/index');
      $config['total_rows'] = $this->provinsi->getTotalData();

      $rsProvinsi = $this->provinsi->getProvinsi($offset, $limit)->result();

      for($i=0; $i < count($rsProvinsi); $i++){
        $id = $rsProvinsi[$i]->id;
        $name = $rsProvinsi[$i]->name;

        // $rsKota = $this->kota->getKota("provinsi",$id);
        $this->kota->provinsi_id = $id;
        $rsKota = $this->kota->getTotalData();
        $rsKecamatan = $this->kecamatan->getKecamatan("provinsi",$id);
        $rsKelurahan = $this->kelurahan->getKelurahan("provinsi",$id);
        $rsTps = $this->pemilih->getTotalDataTps("provinsi",$id);
        $rsPemilih = $this->pemilih->getPemilih("provinsi",$id);

        $dataProvinsi[$i]['id'] = $id; 
        $dataProvinsi[$i]['nama'] = $name; 
        $dataProvinsi[$i]['jKota'] = $rsKota;
        $dataProvinsi[$i]['jKecamatan'] = $rsKecamatan->num_rows();
        $dataProvinsi[$i]['jKelurahan'] = $rsKelurahan->num_rows();
        $dataProvinsi[$i]['jTps'] = $rsTps;
        $dataProvinsi[$i]['jPemilih'] = $rsPemilih->num_rows();

      }
      
      $this->pagination->initialize($config);
      $data['judul'] = "Data Provinsi";
      $data['breadcrumbs'] = "Provinsi";
      $data['provinsi'] = $dataProvinsi;
      $data["paginator"] = $this->pagination->create_links();
      $this->render_page('provinsi',$data);

    }

  }
?>
