<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	public function index()
	{
		show_error('error', 400);
		die();
	}
	
	public function publish()
	{
		if($this->input->server('REQUEST_METHOD') != "POST")
		{
			show_error('error', 400);
			die();
		}
		
		// Get the POST body
		$json = file_get_contents('php://input');
		if($json == null || strlen($json) == 0)
		{
			show_error('error', 400);
			die();
		}
		
		// Parse the JSON
		$jsonObject = json_decode($json, false, 2);
		if($jsonObject == null)
		{
			show_error('error', 400);
			die();
		}
		
		$verifiedJson = json_encode($jsonObject);
		if($verifiedJson == null)
		{
			show_error('error', 400);
			die();
		}
		
		$this->load->model('sensors_model');
		$result = $this->sensors_model->publish($verifiedJson);
		if($result)
		{
			$out->status = "success";
			echo json_encode($out);
		}
		else
		{
			show_error('error', 500);
			die();
		}
	}
}

/* End of file api.php */
/* Location: ./application/controllers/api.php */