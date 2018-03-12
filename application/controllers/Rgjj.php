<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rgjj extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('settings_model','settings');
		$this->load->library('session');
	}

	public function lesson_chooser()
	{
		$query = $this->db->query("SELECT lastRGJJlesson FROM settings LIMIT 1");
		$result = $query->row_array();
		$rgjjnum = $result['lastRGJJlesson'];
		$rgjjfile = $rgjjnum . ".jpg";
		$rgjjpath = base_url('assets/images/rgjj360/');

		$data = array(
		    'rgjjfile' => $rgjjfile,
		    'rgjjnum' => $rgjjnum,
				'rgjjpath' => $rgjjpath
		);

		$this->load->helper('url');
		$this->load->view('partial/header');
		$this->load->view('rgjj_view',$data);
		$this->load->view('partial/footer');
	}

	public function save_rgjj360($rgjjno)
	{

		$data = array(
        'lastRGJJlesson' => $rgjjno,
				'lastRGJJlessondate' => date("Y-m-d")
		);
		$this->db->update('settings', $data);
		//echo $rgjjno;
		echo json_encode(array("status" => TRUE));

	}

}
