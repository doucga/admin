<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classlist extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Load session library
		$this->load->library('session');
		$this->load->model('Classlist_model','reports');

	}

	public function class_list()
	{
			$this->load->helper('url');
			$programID = $this->uri->segment(3);
			$programName = $this->uri->segment(4);

			$this->load->view('partial/header');
			$this->load->view('class_list_view',$programID,$programName);
			$this->load->view('partial/footer');

	}

	public function reports_by_student()
	{

			$this->load->helper('url');
			$this->load->view('partial/header');
			$this->load->view('reports_by_student_view');
			$this->load->view('partial/footer');

	}

public function ajax_classlist()
	{
		$list = $this->reports->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $reports) {
			$no++;
			$row = array();
			$row[] = $reports->first;
			$row[] = $reports->last;
			$row[] = date('g:i A',$reports->classTime);
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->reports->count_all(),
						"recordsFiltered" => $this->reports->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
}

	public function ajax_student_list()
	{
		$list = $this->reports->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $reports) {
			$no++;
			$row = array();
			$row[] = $reports->first;
			$row[] = $reports->last;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->reports->count_all(),
						"recordsFiltered" => $this->reports->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_delete($id)
	{
		$this->student->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function program_list()
	{
		$list = $this->reports->get_programs();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $program) {
			$no++;
			$row = array();
			$row[] = $program->ProgramName;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->program->count_all(),
						"recordsFiltered" => $this->program->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function get_students()
	{
		$list = $this->student->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $reports) {
			$no++;
			$row = array();
			$row[] = $reports->first;
			$row[] = $reports->last;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->reports->count_all(),
						"recordsFiltered" => $this->reports->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
}
