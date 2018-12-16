<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function __construct()
    {
		parent ::__construct();
		$this->load->model('M_Login', 'login', true);        
    }

    public function index()
    {	
    	$data['judul'] = "";
    	$data['breadcrumbs'] = "";
    	$this->render_page('login', $data);
    }

    public function proses()
    {
    	$username = $this->input->post('username');
    	$password = $this->input->post('password');

        $result = $this->login->prosesAdmin($username, $password);

        if($result){
        	redirect(base_url()."pemilih/list");
        }
        else {
	        $this->session->set_flashdata('failed', 'Gagal login username dan password tidak cocok');
	        header("Location: " . $_SERVER["HTTP_REFERER"]);  
        }
      
    }

	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url()."login");
  	}
}

?>