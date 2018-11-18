<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Pemilih extends MY_Controller{
    
    function __construct(){
      parent ::__construct();
      $this->load->library('pagination');
      $this->load->model('M_Pemilih','pemilih',true);
      $this->pilihan = array(""=>"Semua Kategori",
                  "A"=>"A. Partai saya, Caleg saya",
                  "B"=>"B. Partai saya, Belum ada caleg",
                  "C"=>"C. Tidak tahu / Tidak jawab",
                  "D"=>"D. Partai saya, Caleg lain",
                  "E"=>"E. Partai lain, Caleg lain"
                );
      $this->tipePemilih = array( ""=>"Semua Tipe Pemilih",
                                  "1"=>"1. Tim Profesional",
                                  "2"=>"2. Kerabat / Keluarga",
                                  "3"=>"3. Tim Partai",
                                  "4"=>"4. Primodial (club, perkumpulan, dll",
                                  "5"=>"5. Birokrat",
                                  "6"=>"6. relawan",
                                );

      $this->listKontak = array( ""=>"Semua",
                                 "0"=>"Tidak Memberi Kontak",
                                 "1"=>"Memberi Kontak");
    }

    public function index(){
      $tps = $this->uri->segment(3);
      $kelurahan = $this->uri->segment(4);

      $this->pemilih->tps = $tps;
      $this->pemilih->kelurahan = $kelurahan;

      $rsPemilih = $this->pemilih->getAllData()->result();

      $data['listPilihan'] = $this->pilihan;
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

      // if($jawaban[0] == "Partai ".partai." dan caleg ".namaCaleg or $jawaban[0] == "Tidak tau partai mana tetapi calegnya ".namaCaleg){
      $this->pemilih->memilih = idCaleg;
      $this->pemilih->id = $idPemilih;
      $this->pemilih->save();
      $this->mInterview->memilih = $jawaban[0];
      $this->mInterview->tipe_pemilih = $jawaban[1];
      $this->mInterview->banyak_pemilih = $jawaban[2];
      $this->mInterview->kontak = $jawaban[3];
      // }


      $this->mInterview->simpan();
      $idMaster = $this->mInterview->id;

      for ($i = 0; $i < count($pertanyaan) ; $i++) {          
          if($pertanyaan[$i]!="" ){
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
      $this->load->model('M_Kecamatan', 'kecamatan', true);

      $dataPemilih = array();
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

      for($i = 0; $i < count($dPemilih);$i++){
        $dataPemilih[$i]['id'] = $dPemilih[$i]->id;
        $dataPemilih[$i]['nik'] = $dPemilih[$i]->nik;
        $dataPemilih[$i]['nama'] = $dPemilih[$i]->nama;
        $dataPemilih[$i]['tempat_lahir'] = $dPemilih[$i]->tempat_lahir;
        $dataPemilih[$i]['nama_kelurahan'] = $dPemilih[$i]->nama_kelurahan;
        $dataPemilih[$i]['tps'] = $dPemilih[$i]->tps;
        $dataPemilih[$i]['memilih'] = $dPemilih[$i]->memilih;

        $this->kecamatan->name = false;
        $this->kecamatan->id = $dPemilih[$i]->kecamatan;
        $this->kecamatan->getData();

        $dataPemilih[$i]['nama_kecamatan'] = $this->kecamatan->name;
      }

      $data['pemilih'] = $dataPemilih;
      $rsProvinsi = $this->M_Provinsi->getProvinsi()->result();

      $listProvinsi[""] = "Pilih Provinsi";
      foreach ($rsProvinsi as $value) {
        $listProvinsi[$value->id] = $value->name;
      }
      
      $this->pagination->initialize($config);
      $data['listPilihan'] = $this->pilihan;
      $data['listTipePemilih'] = $this->tipePemilih;
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

      $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

      $listLimit = array(10=>10, 25=>25, 50=>50, 75=>75, 100=>100, 200=>200, 250=>250);       
      
      $action = $this->input->post('action');
      
      if($action == "search"){
        $filterData['provinsikons'] = $this->input->post('provinsi');
        $filterData['kotakons'] = $this->input->post('kota');
        $filterData['kecamatankons'] = $this->input->post('kecamatan');
        $filterData['kelurahankons'] = $this->input->post('kelurahan');
        $filterData['searchkons'] = $this->input->post('search');
        $filterData['pilihans'] = $this->input->post('pilihan');
        $filterData['pemilihs'] = $this->input->post('pemilih');
        $filterData['kontaks'] = $this->input->post('kontak');
        $filterData['tpss'] = $this->input->post('tps');
        $filterData['limitkons'] = $this->input->post('limit');
        $this->session->set_userdata($filterData);
      }

      $provinsi = $this->session->userdata('provinsikons');
      $kota = $this->session->userdata('kotakons');
      $kecamatan = $this->session->userdata('kecamatankons');
      $kelurahan = $this->session->userdata('kelurahankons');
      $search = $this->session->userdata('searchkons');
      $pilihan = $this->session->userdata('pilihans');
      $tipePemilih = $this->session->userdata('pemilihs');
      $kontak = $this->session->userdata('kontaks');
      $tps = $this->session->userdata('tpss');
      $limit = $this->session->userdata('limitkons');
      
      $dataPemilih = array();

      $tPemilih = 0;
      $tKonsolidasi = 0;
      $tA = 0;
      $tB = 0;
      $tC = 0;
      $tD = 0;
      $tE = 0;

      $config['base_url'] = base_url('Pemilih/konsolidasi');
      $config['per_page'] = $limit; 


      $data['judul'] = "List Pemilih";
      $data['breadcrumbs'] = "";

      $data['provinsi'] = $provinsi;
      $data['kota'] = $kota;
      $data['kecamatan'] = $kecamatan;
      $data['kelurahan'] = $kelurahan;
      $data['tps'] = $tps;
      $data['search'] = $search;
      $data['limit'] = $limit;

      $this->pemilih->provinsi = $provinsi;
      $this->pemilih->kota = $kota;
      $this->pemilih->kecamatan = $kecamatan;
      $this->pemilih->kelurahan = $kelurahan;
      $this->pemilih->memilih = idCaleg;
      $this->pemilih->pilihan = $pilihan;
      $this->pemilih->tipePemilih = $tipePemilih;
      $this->pemilih->kontak = $kontak;
      $this->pemilih->tps = $tps;

      if ($provinsi != "") {
        $tPemilih = $this->pemilih->getTotalData($search);
        $config['total_rows'] = $tPemilih;

        $dPemilih = $this->pemilih->getAllData($page, $limit, $search)->result();
        
        for($i = 0; $i < count($dPemilih);$i++){
          $dataPemilih[$i]['id'] = $dPemilih[$i]->id;
          $dataPemilih[$i]['nik'] = $dPemilih[$i]->nik;
          $dataPemilih[$i]['nama'] = $dPemilih[$i]->nama;
          $dataPemilih[$i]['tempat_lahir'] = $dPemilih[$i]->tempat_lahir;
          $dataPemilih[$i]['nama_kelurahan'] = $dPemilih[$i]->nama_kelurahan;
          $dataPemilih[$i]['tps'] = $dPemilih[$i]->tps;
          $dataPemilih[$i]['tipe_pemilih'] = $dPemilih[$i]->tipe_pemilih;
          
          $this->kecamatan->provinsi = false;
          $this->provinsi->id = $dPemilih[$i]->provinsi;
          $this->provinsi->getData();
          
          $this->kota->name = false;
          $this->kota->id = $dPemilih[$i]->kota;
          $this->kota->getData();

          $this->kecamatan->name = false;
          $this->kecamatan->id = $dPemilih[$i]->kecamatan;
          $this->kecamatan->getData();

          $dataPemilih[$i]['nama_provinsi'] = $this->provinsi->name;
          $dataPemilih[$i]['nama_kota'] = $this->kota->name;
          $dataPemilih[$i]['nama_kecamatan'] = $this->kecamatan->name;
          $dataPemilih[$i]['pilihan'] = $dPemilih[$i]->memilih;
          $dataPemilih[$i]['jumPemilih'] = $dPemilih[$i]->banyak_pemilih;
          $dataPemilih[$i]['kontak'] = $dPemilih[$i]->kontak;
        }


      }  

      $data['pemilih'] = $dataPemilih;
      $rsProvinsi = $this->M_Provinsi->getProvinsi()->result();

      $listProvinsi[""] = "Pilih Provinsi";
      foreach ($rsProvinsi as $value) {
        $listProvinsi[$value->id] = $value->name;
      }
      
      $this->pagination->initialize($config);
      $data['kontak'] = $kontak;
      $data['pilihan'] = $pilihan;
      $data['tipePemilih'] = $tipePemilih;
      $data['listKontak'] = $this->listKontak;
      $data['listPilihan'] = $this->pilihan;
      $data['listTipePemilih'] = $this->tipePemilih;
      $data['listLimit'] = $listLimit;
      $data['listProvinsi'] = $listProvinsi;
      $data["paginator"] = $this->pagination->create_links();
      $data["totalData"] = $tPemilih;

      if($tPemilih > 0){
        $this->pemilih->memilih = idCaleg;
        $this->pemilih->pilihan = false;
        $tKonsolidasi = $this->pemilih->getTotalData();
        
        $this->pemilih->pilihan = "A";
        $tA = $this->pemilih->getTotalDataPemilih();
        
        $this->pemilih->pilihan = "B";
        $tB = $this->pemilih->getTotalDataPemilih();
        
        $this->pemilih->pilihan = "C";
        $tC = $this->pemilih->getTotalDataPemilih();        
        
        $this->pemilih->pilihan = "D";
        $tD = $this->pemilih->getTotalDataPemilih();
                
        $this->pemilih->pilihan = "E";
        $tE = $this->pemilih->getTotalDataPemilih();
        
      }
      $data["totalA"] = $tA; 
      $data["totalB"] = $tB;      
      $data["totalC"] = $tC;      
      $data["totalD"] = $tD;      
      $data["totalE"] = $tE;      
      $data["totalKonsolidasi"] = $tKonsolidasi; 
      $this->render_page('pemilih/konsolidasi', $data);
    }

    public function getInterview(){
      $this->load->model("M_Interview_master", "interview", true);
      $this->interview->caleg_id = idCaleg;
      $this->interview->pemilih_id = $this->input->post('idPemilih');
      $data = $this->interview->viewInterview();

      echo json_encode($data);
    }

    public function editInterview(){
      $this->load->model("M_Interview_master", "mInterview", true);
      $this->load->model("M_Interview_detail", "dInterview", true);
      $this->load->model("M_Pemilih", "pemilih", true);

      $idMaster = $this->input->post('idMaster');

      $this->mInterview->id = $idMaster;
      $this->dInterview->m_interview_id = $idMaster;

      $this->mInterview->hapus();
      $this->dInterview->hapus();

      $idPemilih = $this->input->post('idPemilih');
      $idCaleg = $this->input->post('idCaleg');
      $pertanyaan = $this->input->post('pertanyaan');
      $jawaban = $this->input->post('jawaban');


      $this->mInterview->caleg_id = $idCaleg;
      $this->mInterview->pemilih_id = $idPemilih;
      $this->mInterview->user_id = "1";
      $this->mInterview->memilih = "0";
      $this->mInterview->tipe_pemilih = "R";

      $this->pemilih->memilih = idCaleg;
      $this->pemilih->id = $idPemilih;
      $this->pemilih->save();

      $this->mInterview->memilih = $jawaban[0];
      $this->mInterview->tipe_pemilih = $jawaban[1];
      $this->mInterview->banyak_pemilih = $jawaban[2];
      $this->mInterview->kontak = $jawaban[3];

      $this->mInterview->simpan();
      $idMaster = $this->mInterview->id;

      for ($i = 0; $i < count($pertanyaan) ; $i++) {          
          if($pertanyaan[$i]!=""){
            $this->dInterview->m_interview_id = $idMaster;
            $this->dInterview->pertanyaan = $pertanyaan[$i];
            $this->dInterview->jawaban = $jawaban[$i];
            $this->dInterview->simpan();          
          }
      }
      redirect(base_url()."pemilih/konsolidasi/");
    }  

    function hapusKonsolidasi(){
      $id = $this->uri->segment(3);
      $this->pemilih->hapusKonsolidasi($id);

      $this->session->set_flashdata('success', 'Berhasil hapus data konsolidasi');  
      header("Location: " . $_SERVER["HTTP_REFERER"]);  
    }
  }
?>
