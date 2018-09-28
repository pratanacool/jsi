<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Kota extends MY_Controller{
    function __construct(){
      parent ::__construct();
      $this->load->library('pagination');
    }

    public function index(){
      $this->load->model('M_Kota', 'kota', true);
      $this->load->model('M_Kecamatan', 'kecamatan', true);
      $this->load->model('M_Kelurahan', 'kelurahan', true);
      $this->load->model('M_Pemilih','pemilih',true);

      $idProvinsi = $this->uri->segment(3);

      $this->kota->provinsi_id = $idProvinsi;
      $dataKota = array();
      
      $limit = 5;      


      $page = $this->uri->segment(5);

      if($page == 0):
        $offset = 0;
      else:
        $offset = $page;
      endif;      

      $config['base_url'] = base_url('Kota/index/'.$idProvinsi.'/0');
      $config['per_page'] = $limit;      
      $config['total_rows'] = $this->kota->getTotalData();

      $rsKota = $this->kota->getAllData($offset, $limit)->result();

      for($i=0; $i < count($rsKota); $i++){
        $id = $rsKota[$i]->id;
        $name = $rsKota[$i]->name;

        $rsKecamatan = $this->kecamatan->getKecamatan("kota",$id);
        $rsKelurahan = $this->kelurahan->getKelurahan("kota",$id);
        $rsTps = $this->pemilih->getTotalDataTps("kota",$id);
        $rsPemilih = $this->pemilih->getPemilih("kota",$id);

        $dataKota[$i]['id'] = $id; 
        $dataKota[$i]['nama'] = $name; 
        $dataKota[$i]['jKecamatan'] = $rsKecamatan;
        $dataKota[$i]['jKelurahan'] = $rsKelurahan;
        $dataKota[$i]['jTps'] = $rsTps;
        $dataKota[$i]['jPemilih'] = $rsPemilih;

      }
      $this->pagination->initialize($config);
      $data['judul'] = "Data Kota";
      $data['breadcrumbs'] = "Provinsi;Kota";
      $data['kota'] = $dataKota;
      $data["paginator"] = $this->pagination->create_links();
      $this->render_page('kota',$data);

    }    




  }
?>
