<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Kecamatan extends MY_Controller{
    function __construct(){
      parent ::__construct();
      $this->load->library('pagination');
    }

    public function index(){
      $this->load->model('M_Kecamatan', 'kecamatan', true);
      $this->load->model('M_Kelurahan', 'kelurahan', true);
      $this->load->model('M_Pemilih','pemilih',true);

      $idKota = $this->uri->segment(3);

      $this->kecamatan->kota_id = $idKota;
      $dataKecamatan = array();
      
      $limit = 10;      


      $page = $this->uri->segment(5);

      if($page == 0):
        $offset = 0;
      else:
        $offset = $page;
      endif;      

      $config['base_url'] = base_url('Kecamatan/index/'.$idKota.'/0');
      $config['per_page'] = $limit;      
      $config['total_rows'] = $this->kecamatan->getAllData()->num_rows();

      $rsKecamatan = $this->kecamatan->getAllData($offset, $limit)->result();

      for($i=0; $i < count($rsKecamatan); $i++){
        $id = $rsKecamatan[$i]->id;
        $name = $rsKecamatan[$i]->name;

        $rsKelurahan = $this->kelurahan->getKelurahan("kecamatan",$id);
        $rsTps = $this->pemilih->getTps("kecamatan",$id);
        $rsPemilih = $this->pemilih->getPemilih("kecamatan",$id);

        $dataKecamatan[$i]['id'] = $id; 
        $dataKecamatan[$i]['nama'] = $name; 
        $dataKecamatan[$i]['jKelurahan'] = $rsKelurahan->num_rows();
        $dataKecamatan[$i]['jTps'] = $rsTps->num_rows();
        $dataKecamatan[$i]['jPemilih'] = $rsPemilih->num_rows();

      }
      $this->pagination->initialize($config);
      $data['judul'] = "Data Kecamatan";
      $data['breadcrumbs'] = "Provinsi;Kota;Kecamatan";
      $data['kecamatan'] = $dataKecamatan;
      $data["paginator"] = $this->pagination->create_links();
      // var_dump($data);die();
      $this->render_page('kecamatan',$data);

    }    




  }
?>
