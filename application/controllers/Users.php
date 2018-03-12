<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Load session library
		$this->load->library('session');
		$this->load->model('users_model','users');

	}

	public function display_users()
	{

			$this->load->helper('url');
			$this->load->view('partial/header');
			$this->load->view('users_view');
			$this->load->view('partial/footer');

	}

	public function ajax_list()
	{
		$list = $this->users->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $users) {
			$no++;
			$row = array();
			$row[] = $users->first_name;
			$row[] = $users->last_name;
			$row[] = $users->user_name;
			$row[] = $users->user_type;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_user('."'".$users->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_user('."'".$users->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->users->count_all(),
						"recordsFiltered" => $this->users->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->users->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'user_name' => $this->input->post('user_name'),
				'user_type' => $this->input->post('user_type'),
				'user_password' => $this->input->post('user_password'),
			);
		$insert = $this->users->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'user_name' => $this->input->post('user_name'),
			'user_type' => $this->input->post('user_type'),
			'user_password' => $this->input->post('user_password'),
			);
		$this->users->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}



	public function ajax_delete($id)
	{
		$this->users->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}



}
