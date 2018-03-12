<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roycegjj extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('settings_model','settings');
	}

	public function display_rgjj()
	{
		$query = $this->db->query("SELECT lastRGJJlesson FROM settings LIMIT 1");
		$result = $query->row_array();
		$rgjjnum = $result['lastRGJJlesson'];
		$rgjjfile = "'" . base_url('assets/images/rgjj360/') . "/" . $rgjjnum . ".jpg" . "'";
		$data['rgjjfile'] = $rgjjfile;
		$this->load->helper('url');
		$this->load->view('rgjj_view',$data);
	}
}
