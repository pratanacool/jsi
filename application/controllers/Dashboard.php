<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Dashboard extends MY_Controller
  {
    function __construct()
    {
      parent ::__construct();
      $this->load->library('pagination');
    }

    public function index()
    {
      $limit = 10;
      $this->load->model('M_Pemilih','pemilih',true);
      
      $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
      
      
      $config['per_page'] = $limit;      
      $config['base_url'] = base_url('Dashboard/index');
      $config['total_rows'] = $this->pemilih->getAllData()->num_rows();
      
      $this->pagination->initialize($config);

      $data['pemilih'] = $this->pemilih->getAllData($offset, $limit)->result();
      $data["paginator"] = $this->pagination->create_links();
      $this->render_page('dashboard',$data);

    }
    
  }
?>
