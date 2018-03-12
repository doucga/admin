<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_model','programs');
		$this->load->model('attendance_model','attendance');
	}

	public function attendance_list()
	     {
				 		$this->load->model('attendance_model','attendance');
						//call the model function to get the list data
	          $attresult = $this->attendance_model->get_attendance_list();
	          $data['attlist'] = $attresult;
	          //load the department_view
						$this->load->view('home_view',$data);
	     }

	public function ajax_attendance_list()
  {
		$list = $this->attendance->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $attendance) {
			$no++;
			$row = array();
			$row[] = $attendance->classID;
			$row[] = $studentID->studentIDID;
			$row[] = $programID->programID;
			$row[] = $classDate->classDate;
			$row[] = $classTime->classTime;
			$row[] = $lessonNumber->lessonNumber;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->attendance->count_all(),
						"recordsFiltered" => $this->attendance->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
  }

		public function ajax_list()
	{
		$list = $this->programs->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $programs) {
			$no++;
			$row = array();
			$row[] = $programs->ProgramName;
			$row[] = dateFormat('g:i A',$programs->starttime);
			$this->db->where('programID', $programs->programID);
			$this->db->where('classDate', date('Y-m-d'));
			$query = $this->db->get('attendance');
			$row[] = $query->num_rows();
			$url = "'" . site_url('classlist/class_list/') . "/" . $programs->programID . "/" . $programs->ProgramName . "'";
			//$row[] = '<a class="btn btn-sm btn-success" title="Class List" onclick="class_list(' . $programs->programID .')"> Class List</a>';
			$row[] = '<a class="btn btn-sm btn-success" title="Class List" onclick="location.href=' . $url .'"> Class List</a>';
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
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'ProgramName' => $this->input->post('ProgramName'),

			);
		$insert = $this->programs->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
			'ProgramName' => $this->input->post('ProgramName'),
			);
		$this->programs->update(array('programID' => $this->input->post('programID')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update_payment()
	{
		$data = array(
				'ProgramName' => $this->input->post('ProgramName'),
			);
		$this->programs->update(array('programID' => $this->input->post('programID')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->programs->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function program_list()
	{
		$list = $this->programs->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $programs) {
			$no++;
			$row = array();
			$row[] = $programs->programID;
			$row[] = $programs->ProgrameName;
			//add html for action
			$row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Payment" onclick="class_list(programID)"><i class="glyphicon glyphicon-usd"></i> Attendee List</a>';
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

	public function get_last_rgjj360()
	{
		$query = $this->db->query("SELECT * FROM settings LIMIT 1");
		$result = $query->row_array();
		$lastRGJJlesson = $result['lastRGJJlesson'];
		$lastRGJJlessondate = $result['lastRGJJlessondate'];

		//see if there is a JJ class today.
		$this->db->from('programs');
		$this->db->where('weekday', jddayofweek(date('w') - 1, 1));
		$this->db->where('rgjj360', 'Yes');
		$query = $this->db->get();
		$jjtoday = $query->num_rows();
		if ($jjtoday > 0 && $lastRGJJlessondate !== date("Y-m-d")){
			$lastRGJJlesson = $lastRGJJlesson + 1;
			$data = array(
	        'lastRGJJlesson' => $lastRGJJlesson,
					'lastRGJJlessondate' => date("Y-m-d")
			);
			$this->db->update('settings', $data);

		}

		echo $lastRGJJlesson;

	}

	public function save_last_rgjj360($rgjjno)
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
