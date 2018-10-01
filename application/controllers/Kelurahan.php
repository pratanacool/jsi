<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Kelurahan extends MY_Controller{
    function __construct(){
      parent ::__construct();
      $this->load->library('pagination');
      $this->load->model('M_Kelurahan', 'kelurahan', true);
    }

    public function index(){
      $this->load->model('M_Pemilih','pemilih',true);

      $idKecamatan = $this->uri->segment(3);

      $this->kelurahan->kecamatan_id = $idKecamatan;
      $dataKelurahan = array();
      
      $limit = 10;      


      $page = $this->uri->segment(5);

      if($page == 0):
        $offset = 0;
      else:
        $offset = $page;
      endif;      

      $config['base_url'] = base_url('Kelurahan/index/'.$idKecamatan.'/0');
      $config['per_page'] = $limit;      
      $config['total_rows'] = $this->kelurahan->getTotalData();

      $rsKelurahan = $this->kelurahan->getAllData($offset, $limit)->result();

      for($i=0; $i < count($rsKelurahan); $i++){
        $id = $rsKelurahan[$i]->id;
        $name = $rsKelurahan[$i]->name;

        $rsTps = $this->pemilih->getTotalDataTps("kelurahan",$id);
        $rsPemilih = $this->pemilih->getPemilih("kelurahan",$id);

        $dataKelurahan[$i]['id'] = $id; 
        $dataKelurahan[$i]['nama'] = $name; 
        $dataKelurahan[$i]['jTps'] = $rsTps;
        $dataKelurahan[$i]['jPemilih'] = $rsPemilih;

      }
      $this->pagination->initialize($config);
      $data['judul'] = "Data Kecamatan";
      $data['breadcrumbs'] = "Provinsi;Kota;Kecamatan;Kelurahan";
      $data['kelurahan'] = $dataKelurahan;
      $data["paginator"] = $this->pagination->create_links();
      $this->render_page('kelurahan',$data);

    }    
 
    public function listKelurahan(){
      $idKelurahan = $this->input->post("id");
      
      $this->kelurahan->kecamatan_id = $idKelurahan;
      $rsKelurahan = $this->kelurahan->getAllData()->result();
      $listKelurahan = array();
      $listKelurahan[""] = "Pilih Kelurahan";
      foreach ($rsKelurahan as $value) {
        $listKelurahan[$value->id] = $value->name;
      }
      echo json_encode($listKelurahan);
    }



  }
?>
