<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Pemilih extends MY_Controller{
    
    function __construct(){
      parent ::__construct();
      $this->load->library('pagination');
      $this->load->model('M_Pemilih','pemilih',true);
    }

    public function index(){
      $tps = $this->uri->segment(3);
      $kelurahan = $this->uri->segment(4);

      $this->pemilih->tps = $tps;
      $this->pemilih->kelurahan = $kelurahan;

      $rsPemilih = $this->pemilih->getAllData()->result();
      // $rsPemilih = $this->pemilih->getTotalData()->result();
      $pilihan = array("",
                  "Partai saya dan caleg saya"=>"Partai saya dan caleg saya",
                  "Partai saya tapi caleg lain (dari partai saya)"=>"Partai saya tapi caleg lain (dari partai saya)",
                  "Partai saya tetapi tidak tau calegnya siapa"=>"Partai saya tetapi tidak tau calegnya siapa",
                  "Partai lain dan caleg lain"=>"Partai lain dan caleg lain",
                  "Tidak tau partai mana tetapi calegnya saya"=>"Tidak tau partai mana tetapi calegnya saya",
                  "Tidak tau partai mana dan caleg siapa"=>"Tidak tau partai mana dan caleg siapa"
                 );

      $data['listPilihan'] = $pilihan;
      $data['judul'] = "Data Kecamatan";
      $data['breadcrumbs'] = "Provinsi;Kota;Kecamatan;Kelurahan;pemilih";
      $data['pemilih'] = $rsPemilih;
      $this->render_page('pemilih/pemilih',$data);
    }    

    public function tps(){
      $idKelurahan = $this->uri->segment(3);

      $this->pemilih->kelurahan = $idKelurahan;
      $dataPemilih = array();
      $limit = 5;
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
        $kelurahan= $rsTps[$i]->kelurahan;

        $rsPemilih = $this->pemilih->getPemilih("tps",$id, $kelurahan);
        $dataPemilih[$i]['nama'] = $id;
        $dataPemilih[$i]['kelurahan'] = $kelurahan;
        $dataPemilih[$i]['jPemilih'] = $rsPemilih;
      }
      
      $this->pagination->initialize($config);
      $data['judul'] = "Data TPS";
      $data['breadcrumbs'] = "Provinsi;Kota;Kecamatan;Kelurahan;TPS";
      $data['tps'] = $dataPemilih;
      $data["paginator"] = $this->pagination->create_links();
      $this->render_page('pemilih/tps',$data);
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

    public function simpanInterview(){
      $this->load->model("M_Interview_master", "mInterview", true);
      $this->load->model("M_Interview_detail", "dInterview", true);

      $idPemilih = $this->input->post('id');
      $idCaleg = $this->input->post('idCaleg');
      $pertanyaan = $this->input->post('pertanyaan');
      $jawaban = $this->input->post('jawaban');

      $this->mInterview->caleg_id = $idCaleg;
      $this->mInterview->pemilih_id = $idPemilih;
      $this->mInterview->user_id = "1";


      switch ($jawaban[0]) {
        case "Partai saya dan caleg saya":
        case "Tidak tau partai mana tetapi calegnya saya":
          $this->mInterview->memilih = "1";
          break;

        default:
          $this->mInterview->memilih = "0";
          break;
      }

      $this->mInterview->simpan();
      $idMaster = $this->mInterview->id;

      for ($i = 0; $i < count($pertanyaan) ; $i++) {          
          if($pertanyaan[$i]!="" && $jawaban[$i]!=""){
            $this->dInterview->m_interview_id = $idMaster;
            $this->dInterview->pertanyaan = $pertanyaan[$i];
            $this->dInterview->jawaban = $jawaban[$i];
            $this->dInterview->simpan();          
          }
      }
      var_dump($pertanyaan);
      var_dump($jawaban);
      die();
    }

    public function list(){
      $this->load->model("M_Provinsi");
      $provinsi = $this->input->post('provinsi');
      $kota = $this->input->post('kota');
      $kecamatan = $this->input->post("kecamatan");
      $kelurahan = $this->input->post("kelurahan");
      $search = $this->input->post("search");
      
      $dPemilih = array();
      
      $data['judul'] = "List Pemilih";
      $data['breadcrumbs'] = "";

      $data['provinsi'] = $provinsi;
      $data['kota'] = $kota;
      $data['kecamatan'] = $kecamatan;
      $data['kelurahan'] = $kelurahan;
      $data['search'] = $search;
      
      if ($provinsi != "" or $search !="") {
        $dPemilih = $this->pemilih->getAllData(null, null, $search)->result();
      } 

      $data['pemilih'] = $dPemilih;
      $rsProvinsi = $this->M_Provinsi->getProvinsi()->result();

      $listProvinsi[""] = "Pilih Provinsi";
      foreach ($rsProvinsi as $value) {
        $listProvinsi[$value->id] = $value->name;
      }

      $data['listProvinsi'] = $listProvinsi;
      $this->render_page('pemilih/list', $data);
    }


  }
?>
