<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Pemilih extends MY_Controller{
    
    function __construct(){
      parent ::__construct();
      $this->load->library('pagination');
      $this->load->model('M_Pemilih','pemilih',true);
    }

    public function index(){
      $idKelurahan = $this->uri->segment(3);

      $this->pemilih->tps = $idKelurahan;

      $rsPemilih = $this->pemilih->getAllData()->result();
      // $rsPemilih = $this->pemilih->getTotalData()->result();
      $data['judul'] = "Data Kecamatan";
      $data['breadcrumbs'] = "Provinsi;Kota;Kecamatan;Kelurahan;pemilih";
      $data['pemilih'] = $rsPemilih;
      $this->render_page('pemilih',$data);
    }    

    public function tps(){
      $idKelurahan = $this->uri->segment(3);

      $this->pemilih->kelurahan = $idKelurahan;
      $dataPemilih = array();
      $limit = 10;
      $page = $this->uri->segment(5);

      if($page == 0):
        $offset = 0;
      else:
        $offset = $page;
      endif; 

      $config['base_url'] = base_url('Pemilih/tps/'.$idKelurahan.'/0');
      $config['per_page'] = $limit;      
      $config['total_rows'] = $this->pemilih->getTotalDataTps("kelurahan", $idKelurahan);

      $rsTps = $this->pemilih->getAllDataTps("kelurahan", $idKelurahan, $offset, $limit)->result();

      for ($i = 0; $i < count($rsTps); $i++) {
        $id = $rsTps[$i]->id;

        $rsPemilih = $this->pemilih->getPemilih("tps",$id);
        $dataPemilih[$i]['nama'] = $id;
        $dataPemilih[$i]['jPemilih'] = $rsPemilih->num_rows();
      }
      
      $this->pagination->initialize($config);
      $data['judul'] = "Data TPS";
      $data['breadcrumbs'] = "Provinsi;Kota;Kecamatan;Kelurahan;TPS";
      $data['tps'] = $dataPemilih;
      $data["paginator"] = $this->pagination->create_links();
      $this->render_page('tps',$data);
    }    

    public function simpan(){
      $this->pemilih->id = $this->input->post('id');
      $this->pemilih->nik = $this->input->post('nik');
      $this->pemilih->nama = $this->input->post("nama");
      $this->pemilih->tempatLahir = $this->input->post("tempatLahir");
      $this->pemilih->tanggalLahir = $this->input->post("tanggalLahir");
      $this->pemilih->gender = $this->input->post("gender");
      // die($this->pemilih->gender);
      $hasil = $this->pemilih->save();

      if ($hasil == true) {
        $this->session->set_flashdata('success', 'Berhasil ubah data pemilih');  
      } 
      else {
        $this->session->set_flashdata('failed', 'Gagal ubah data pemilih');
      }

      header("Location: " . $_SERVER["HTTP_REFERER"]);  
    }
    
    public function uploadAPI(){
      $data = json_decode(file_get_contents('php://input'), true);

      // var_dump($data['wilayah']);
      // var_dump($data['aaData']);
      $provinsi = $data['wilayah']['provinsi'];
      $kota = $data['wilayah']['kabkota'];
      $kecamatan = $data['wilayah']['kecamatan'];
      $kelurahan = $data['wilayah']['kelurahan'];

      $dPemilih = $data['aaData'];

      for ($i = 0; $i < count($dPemilih); $i++) {
        $this->pemilih->nik = $dPemilih[$i]['nik'];
        $this->pemilih->nama = $dPemilih[$i]["nama"];
        $this->pemilih->tempatLahir = $dPemilih[$i]["tempatLahir"];
        $this->pemilih->tanggalLahir = "1900-01-01";
        $this->pemilih->gender = $dPemilih[$i]["jenisKelamin"];
        $this->pemilih->tps = $dPemilih[$i]["tps"];
        $this->pemilih->provinsi = $provinsi;
        $this->pemilih->kota = $kota;
        $this->pemilih->kecamatan = $kecamatan;
        $this->pemilih->kelurahan = $kelurahan;
        $hasil = $this->pemilih->save();
        if($hasil == true){
          echo "masuk <br>";
        }
      }


      echo "selesai";
    }




  }
?>
