<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  class MY_Controller extends CI_Controller{
    function render_page($content, $data = NULL){
        $data['header'] = $this->load->view('template/Header', $data, TRUE);
        $data['isi'] = $this->load->view($content, $data, TRUE);
        $data['footer'] = $this->load->view('template/Footer', $data, TRUE);
        $data['leftMenu'] = $this->load->view('template/LeftMenu', $data, TRUE);
        $data['rightMenu'] = $this->load->view('template/RightMenu', $data, TRUE);

        $this->load->view('template/Main', $data);
    }
    function getBreadcrumbs($id){
        $this->load->model('M_Provinsi', 'provinsi', true);
        $this->load->model('M_Kota', 'kota', true);
        $this->load->model('M_Kecamatan', 'kecamatan', true);
        $this->load->model('M_Kelurahan', 'kelurahan', true);
        $cId = strlen($id);
        $tps = "";
        if($cId == 2){
            $this->provinsi->id = $id; 
            $this->provinsi->getData();
            $breadcrumbs = $this->provinsi->name.";KOTA";
        }
        elseif ($cId == 4) {
            $this->provinsi->id = substr($id,0,2); 
            $this->provinsi->getData();    

            $this->kota->id = $id; 
            $this->kota->getData();
            $breadcrumbs = $this->provinsi->name.";".$this->kota->name.";KECAMATAN";   
        }        

        elseif ($cId == 7) {
            $this->provinsi->id = substr($id,0,2); 
            $this->provinsi->getData();    

            $this->kota->id = substr($id,0,4); 
            $this->kota->getData();

            $this->kecamatan->id = $id; 
            $this->kecamatan->getData();
            $breadcrumbs = $this->provinsi->name.";".$this->kota->name.";".$this->kecamatan->name.";KELURAHAN";      
        }        

        elseif ($cId == 10) {
            $this->provinsi->id = substr($id,0,2); 
            $this->provinsi->getData();    

            $this->kota->id = substr($id,0,4); 
            $this->kota->getData();

            $this->kecamatan->id = substr($id,0,7); 
            $this->kecamatan->getData();      

            $this->kelurahan->id = $id; 
            $this->kelurahan->getData();
            $breadcrumbs = $this->provinsi->name.";".$this->kota->name.";".$this->kecamatan->name.";".$this->kelurahan->name.";TPS";      
        }        

        elseif ($cId > 10) {
            $this->provinsi->id = substr($id,0,2); 
            $this->provinsi->getData();    

            $this->kota->id = substr($id,0,4); 
            $this->kota->getData();

            $this->kecamatan->id = substr($id,0,7); 
            $this->kecamatan->getData();      

            $this->kelurahan->id = substr($id,0,10); 
            $this->kelurahan->getData();
            $tps = substr($id,10,2);
            $breadcrumbs = $this->provinsi->name.";".$this->kota->name.";".$this->kecamatan->name.";".$this->kelurahan->name.";".$tps.";DAFTAR PEMILIH";
        }
        return $breadcrumbs;
    }
  }


?>
