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
                  "Partai ".partai." dan caleg ".namaCaleg.""=>"Partai ".partai." dan caleg ".namaCaleg."",
                  "Partai ".partai." tapi caleg lain (dari partai ".partai.")"=>"Partai ".partai." tapi caleg lain (dari partai ".partai.")",
                  "Partai ".partai." tetapi tidak tau calegnya siapa"=>"Partai ".partai." tetapi tidak tau calegnya siapa",
                  "Partai lain dan caleg lain"=>"Partai lain dan caleg lain",
                  "Tidak tau partai mana tetapi calegnya ".namaCaleg=>"Tidak tau partai mana tetapi calegnya ".namaCaleg,
                  "Tidak tau partai mana dan caleg siapa"=>"Tidak tau partai mana dan caleg siapa"
                 );

      $data['listPilihan'] = $pilihan;
      $data['judul'] = "Data Pemilih";
      $data['breadcrumbs'] = $this->getBreadcrumbs($kelurahan.$tps);
      $data['pemilih'] = $rsPemilih;
      $this->render_page('pemilih/pemilih',$data);
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
        $kelurahan= $rsTps[$i]->kelurahan;

        $rsPemilih = $this->pemilih->getPemilih("tps",$id, $kelurahan);
        $dataPemilih[$i]['nama'] = $id;
        $dataPemilih[$i]['kelurahan'] = $kelurahan;
        $dataPemilih[$i]['jPemilih'] = $rsPemilih;
      }
      
      $this->pagination->initialize($config);
      $data['judul'] = "Data TPS";
      $data['breadcrumbs'] = $this->getBreadcrumbs($idKelurahan);
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
      $this->load->model("M_Pemilih", "pemilih", true);

      $idPemilih = $this->input->post('id');
      $idCaleg = $this->input->post('idCaleg');
      $pertanyaan = $this->input->post('pertanyaan');
      $jawaban = $this->input->post('jawaban');

      $this->mInterview->caleg_id = $idCaleg;
      $this->mInterview->pemilih_id = $idPemilih;
      $this->mInterview->user_id = "1";
      $this->mInterview->memilih = "0";

      if($jawaban[0] == "Partai ".partai." dan caleg ".namaCaleg or $jawaban[0] == "Tidak tau partai mana tetapi calegnya ".namaCaleg){
        $this->pemilih->memilih = idCaleg;
        $this->pemilih->id = $idPemilih;
        $this->pemilih->save();

        $this->mInterview->memilih = "1";
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
      redirect(base_url()."pemilih/list/");
    }

    public function list(){
      $this->load->model("M_Provinsi");
      $pilihan = array("",
                  "Partai ".partai." dan caleg ".namaCaleg.""=>"Partai ".partai." dan caleg ".namaCaleg."",
                  "Partai ".partai." tapi caleg lain (dari partai ".partai.")"=>"Partai ".partai." tapi caleg lain (dari partai ".partai.")",
                  "Partai ".partai." tetapi tidak tau calegnya siapa"=>"Partai ".partai." tetapi tidak tau calegnya siapa",
                  "Partai lain dan caleg lain"=>"Partai lain dan caleg lain",
                  "Tidak tau partai mana tetapi calegnya ".namaCaleg=>"Tidak tau partai mana tetapi calegnya ".namaCaleg,
                  "Tidak tau partai mana dan caleg siapa"=>"Tidak tau partai mana dan caleg siapa"
                 );
      $tPemilih = 0;
      $listLimit = array(10=>10, 25=>25, 50=>50, 75=>75, 100=>100, 200=>200, 250=>250);       
      $action = $this->input->post('action');
      if($action == "search"){
        $filterData['provinsi'] = $this->input->post('provinsi');
        $filterData['kota'] = $this->input->post('kota');
        $filterData['kecamatan'] = $this->input->post('kecamatan');
        $filterData['kelurahan'] = $this->input->post('kelurahan');
        $filterData['search'] = $this->input->post('search');
        $filterData['limit'] = $this->input->post('limit');
        $this->session->set_userdata($filterData);
      }

      $provinsi = $this->session->userdata('provinsi');
      $kota = $this->session->userdata('kota');
      $kecamatan = $this->session->userdata('kecamatan');
      $kelurahan = $this->session->userdata('kelurahan');
      $search = $this->session->userdata('search');
      $limit = $this->session->userdata('limit');

      $dPemilih = array();
      $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;


      $config['base_url'] = base_url('Pemilih/list');
      $config['per_page'] = $limit; 


      $data['judul'] = "List Pemilih";
      $data['breadcrumbs'] = "";

      $data['provinsi'] = $provinsi;
      $data['kota'] = $kota;
      $data['kecamatan'] = $kecamatan;
      $data['kelurahan'] = $kelurahan;
      $data['search'] = $search;
      $data['limit'] = $limit;

      $this->pemilih->provinsi = $provinsi;
      $this->pemilih->kota = $kota;
      $this->pemilih->kecamatan = $kecamatan;
      $this->pemilih->kelurahan = $kelurahan;

      if ($provinsi != "" or $search !="") {
        $tPemilih = $this->pemilih->getTotalData($search);
        $config['total_rows'] = $tPemilih;

        $dPemilih = $this->pemilih->getAllData($page, $limit, $search)->result();
      } 

      $data['pemilih'] = $dPemilih;
      $rsProvinsi = $this->M_Provinsi->getProvinsi()->result();

      $listProvinsi[""] = "Pilih Provinsi";
      foreach ($rsProvinsi as $value) {
        $listProvinsi[$value->id] = $value->name;
      }
      
      $this->pagination->initialize($config);
      $data['listPilihan'] = $pilihan;
      $data['listLimit'] = $listLimit;
      $data['listProvinsi'] = $listProvinsi;
      $data["paginator"] = $this->pagination->create_links();
      $data["totalData"] = $tPemilih;
      $this->render_page('pemilih/list', $data);
    }    

    public function konsolidasi(){
      $this->load->model("M_Provinsi");
      $this->load->model('M_Provinsi', 'provinsi', true);
      $this->load->model('M_Kota', 'kota', true);
      $this->load->model('M_Kecamatan', 'kecamatan', true);
      $this->load->model("M_Interview_master", "interview", true);

      $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

      $listLimit = array(1=>1, 10=>10, 25=>25, 50=>50, 75=>75, 100=>100, 200=>200, 250=>250);       
      
      $action = $this->input->post('action');
      
      if($action == "search"){
        $filterData['provinsikons'] = $this->input->post('provinsi');
        $filterData['kotakons'] = $this->input->post('kota');
        $filterData['kecamatankons'] = $this->input->post('kecamatan');
        $filterData['kelurahankons'] = $this->input->post('kelurahan');
        $filterData['searchkons'] = $this->input->post('search');
        $filterData['limitkons'] = $this->input->post('limit');
        $this->session->set_userdata($filterData);
      }

      $provinsi = $this->session->userdata('provinsikons');
      $kota = $this->session->userdata('kotakons');
      $kecamatan = $this->session->userdata('kecamatankons');
      $kelurahan = $this->session->userdata('kelurahankons');
      $search = $this->session->userdata('searchkons');
      $limit = $this->session->userdata('limitkons');
      
      $dataPemilih = array();

      $tPemilih = 0;
      $config['base_url'] = base_url('Pemilih/konsolidasi');
      $config['per_page'] = $limit; 


      $data['judul'] = "List Pemilih";
      $data['breadcrumbs'] = "";

      $data['provinsi'] = $provinsi;
      $data['kota'] = $kota;
      $data['kecamatan'] = $kecamatan;
      $data['kelurahan'] = $kelurahan;
      $data['search'] = $search;
      $data['limit'] = $limit;

      $this->pemilih->provinsi = $provinsi;
      $this->pemilih->kota = $kota;
      $this->pemilih->kecamatan = $kecamatan;
      $this->pemilih->kelurahan = $kelurahan;
      $this->pemilih->memilih = idCaleg;

      if ($provinsi != "") {
        $tPemilih = $this->pemilih->getTotalData($search);
        $config['total_rows'] = $tPemilih;

        $dPemilih = $this->pemilih->getAllData($page, $limit, $search)->result();
        
        for($i = 0; $i < count($dPemilih);$i++){
          $dataPemilih[$i]['id'] = $dPemilih[$i]->id;
          $dataPemilih[$i]['nik'] = $dPemilih[$i]->nik;
          $dataPemilih[$i]['nama'] = $dPemilih[$i]->nama;
          $dataPemilih[$i]['tempat_lahir'] = $dPemilih[$i]->tempat_lahir;
          $dataPemilih[$i]['tanggal_lahir'] = $dPemilih[$i]->tanggal_lahir;
          $dataPemilih[$i]['gender'] = $dPemilih[$i]->gender;
          $dataPemilih[$i]['nama_kelurahan'] = $dPemilih[$i]->nama_kelurahan;
          $dataPemilih[$i]['tps'] = $dPemilih[$i]->tps;
          
          $this->provinsi->id = $dPemilih[$i]->provinsi;
          $this->provinsi->getData();
          $this->kota->id = $dPemilih[$i]->kota;
          $this->kota->getData();
          $this->kecamatan->id = $dPemilih[$i]->kecamatan;
          $this->kecamatan->getData();

          $dataPemilih[$i]['nama_provinsi'] = $this->provinsi->name;
          $dataPemilih[$i]['nama_kota'] = $this->kota->name;
          $dataPemilih[$i]['nama_kecamatan'] = $this->kecamatan->name;

          $this->interview->caleg_id = idCaleg;
          $this->interview->pemilih_id = $dPemilih[$i]->id;
          $interview = $this->interview->viewInterview();

          $dataPemilih[$i]['pilihan'] = $interview[0]->jawaban;
          $dataPemilih[$i]['jumPemilih'] = $interview[1]->jawaban;
          $dataPemilih[$i]['kontak'] = $interview[1]->jawaban;
        }


      } 

      $data['pemilih'] = $dataPemilih;
      $rsProvinsi = $this->M_Provinsi->getProvinsi()->result();

      $listProvinsi[""] = "Pilih Provinsi";
      foreach ($rsProvinsi as $value) {
        $listProvinsi[$value->id] = $value->name;
      }
      
      $this->pagination->initialize($config);
      $data['listLimit'] = $listLimit;
      $data['listProvinsi'] = $listProvinsi;
      $data["paginator"] = $this->pagination->create_links();
      $data["totalData"] = $tPemilih;
      
      $this->render_page('pemilih/konsolidasi', $data);
    }

    public function getInterview(){
      $this->load->model("M_Interview_master", "interview", true);
      $this->interview->caleg_id = idCaleg;
      $this->interview->pemilih_id = $this->input->post('idPemilih');
      $data = $this->interview->viewInterview();

      echo json_encode($data);
    }
  }
?>
