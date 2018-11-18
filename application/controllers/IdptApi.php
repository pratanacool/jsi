<?php  
	require APPPATH . '/libraries/REST_Controller.php';
	use Restserver\Libraries\REST_Controller;
	
	class IdptApi extends REST_Controller {

	 	function __construct($config = 'rest') {
	        parent::__construct($config);
	    }

 		function index_get(){
	        $data = array(1,2,3,4,5);
	        $this->response($data);
 		}

 		function user_put(){
	        $data = array('returned: '. $this->post('id'));
	        $this->response($data);
 		}

 		function user_post(){
	        $data = array('returned: '. $this->put('id'));
	        $this->response($data);
 		}

 		function user_delete(){
	        $data = array('returned: '. $this->delete('id'));
	        $this->response($data);
 		}

	}
?>