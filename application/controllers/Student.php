<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Load session library
		$this->load->library('session');
		$this->load->model('student_model','student');

	}

	public function display_home()
	{

			$this->load->helper('url');
			$this->load->view('partial/header');
			$this->load->view('home_view');
			$this->load->view('partial/footer');

	}

	public function display_students()
	{

			$this->load->helper('url');
			$this->load->view('partial/header');
			$this->load->view('student_view');
			$this->load->view('partial/footer');

	}

	public function ajax_list()
	{
		$list = $this->student->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $student) {
			$no++;
			$row = array();
			$row[] = $student->first;
			$row[] = $student->last;
			$row[] = $student->phone;
			$row[] = $student->mobile;
			$row[] = $student->paidtodate;
			$row[] = $student->status;
			//add html for action
			$row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Payment" onclick="payment_student('."'".$student->id."'".')"><i class="glyphicon glyphicon-usd"></i> Payment</a>
			<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_student('."'".$student->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_student('."'".$student->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->student->count_all(),
						"recordsFiltered" => $this->student->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->student->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'first' => $this->input->post('first'),
				'last' => $this->input->post('last'),
				'phone' => $this->input->post('phone'),
				'mobile' => $this->input->post('mobile'),
				'email' => $this->input->post('email'),
				'startdate' => $this->input->post('startdate'),
				'emergcontact' => $this->input->post('emergcontact'),
				'emergphone' => $this->input->post('emergphone'),
				'emergemobile' => $this->input->post('emergemobile'),
				'emergeRelation' => $this->input->post('emergeRelation'),
				'rgjjlessonscomplete' => $this->input->post('rgjjlessonscomplete'),
				'subscription' => $this->input->post('subscription'),
				'punches' => $this->input->post('punches'),
				'paidtodate' => $this->input->post('paidtodate'),
				'carecard' => $this->input->post('carecard'),
				'status' => $this->input->post('status'),
			);
		$insert = $this->student->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'first' => $this->input->post('first'),
				'last' => $this->input->post('last'),
				'phone' => $this->input->post('phone'),
				'mobile' => $this->input->post('mobile'),
				'email' => $this->input->post('email'),
				'startdate' => $this->input->post('startdate'),
				'emergcontact' => $this->input->post('emergcontact'),
				'emergphone' => $this->input->post('emergphone'),
				'emergemobile' => $this->input->post('emergemobile'),
				'emergeRelation' => $this->input->post('emergeRelation'),
				'rgjjlessonscomplete' => $this->input->post('rgjjlessonscomplete'),
				'subscription' => $this->input->post('subscription'),
				'punches' => $this->input->post('punches'),
				'paidtodate' => $this->input->post('paidtodate'),
				'carecard' => $this->input->post('carecard'),
				'status' => $this->input->post('status'),
			);
		$this->student->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update_payment()
	{
		$data = array(
				'punches' => $this->input->post('punches'),
				'paidtodate' => $this->input->post('paidtodate'),
			);
		$this->student->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->student->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}



}
