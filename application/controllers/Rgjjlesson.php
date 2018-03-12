<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Rgjj extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('settings_model','settings');
	}

	public function lesson()
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

		$this->load->view('rgjj',$data);
	}
}
