<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Kelurahan extends MY_Controller{
    function __construct(){
      parent ::__construct();
      $this->load->library('pagination');
    }

    public function index(){
      $this->load->model('M_Kelurahan', 'kelurahan', true);
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
      $config['total_rows'] = $this->kelurahan->getAllData()->num_rows();

      $rsKelurahan = $this->kelurahan->getAllData($offset, $limit)->result();

      for($i=0; $i < count($rsKelurahan); $i++){
        $id = $rsKelurahan[$i]->id;
        $name = $rsKelurahan[$i]->name;

        $rsTps = $this->pemilih->getTps("kelurahan",$id);
        $rsPemilih = $this->pemilih->getPemilih("kelurahan",$id);

        $dataKelurahan[$i]['id'] = $id; 
        $dataKelurahan[$i]['nama'] = $name; 
        $dataKelurahan[$i]['jTps'] = $rsTps->num_rows();
        $dataKelurahan[$i]['jPemilih'] = $rsPemilih->num_rows();

      }
      $this->pagination->initialize($config);
      $data['judul'] = "Data Kecamatan";
      $data['breadcrumbs'] = "Provinsi;Kota;Kecamatan;Kelurahan";
      $data['kelurahan'] = $dataKelurahan;
      $data["paginator"] = $this->pagination->create_links();
      $this->render_page('kelurahan',$data);

    }    
 




  }
?>
