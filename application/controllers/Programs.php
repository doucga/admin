<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Load session library
		$this->load->library('session');
		$this->load->model('programs_model','programs');
		$this->load->helper('date');

	}

	public function display_programs()
	{

			$this->load->helper('url');
			$this->load->view('partial/header');
			$this->load->view('programs_view');
			$this->load->view('partial/footer');

	}

	public function ajax_list()
	{
		$list = $this->programs->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $programs) {
			$no++;
			$row = array();
			$row[] = $programs->weekday;
			$row[] = dateFormat('g:i A',$programs->starttime);
			//$row[] = $programs->starttime;
			$row[] = $programs->ProgramName;
			$row[] = dateFormat('g:i A',$programs->check_in_time);
			$row[] = dateFormat('g:i A',$programs->check_in_closed);
			$row[] = $programs->rgjj360;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_program('."'".$programs->programID."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_program('."'".$programs->programID."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->programs->count_all(),
						"recordsFiltered" => $this->programs->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->programs->get_by_id($id);
		$data->starttime = dateFormat('g:iA',$data->starttime);
		$data->check_in_time = dateFormat('g:iA',$data->check_in_time);
		$data->check_in_closed = dateFormat('g:iA',$data->check_in_closed);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'weekday' => $this->input->post('weekday'),
				'starttime' => dateFormat('H:i',$this->input->post('starttime')),
				'ProgramName' => $this->input->post('ProgramName'),
				'check_in_time' => dateFormat('H:i',$this->input->post('check_in_time')),
				'check_in_closed' => dateFormat('H:i',$this->input->post('check_in_closed')),
				'rgjj360' => $this->input->post('rgjj360'),

			);
		$insert = $this->programs->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
			'weekday' => $this->input->post('weekday'),
			'starttime' => dateFormat('H:i',$this->input->post('starttime')),
			'ProgramName' => $this->input->post('ProgramName'),
			'check_in_time' => dateFormat('H:i',$this->input->post('check_in_time')),
			'check_in_closed' => dateFormat('H:i',$this->input->post('check_in_closed')),
			'rgjj360' => $this->input->post('rgjj360'),
			);
		$this->programs->update(array('programID' => $this->input->post('programID')), $data);
		echo json_encode(array("status" => TRUE));
	}



	public function ajax_delete($id)
	{
		$this->programs->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}



}
