<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_reports extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Load session library
		$this->load->library('session');
		$this->load->model('student_model','student');

	}


	public function display_students_reports()
	{

			$this->load->helper('url');
			$this->load->view('partial/header');
			$this->load->view('student_reports_view');
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
			$row[] = $student->status;
			//add html for action
			$url1 = "'" . site_url('student_report_info/info_report/') . "?id=" . $student->id . "'";
			$url2 = "'" . site_url('student_report_attendance/attendance_report/') . "?id=" . $student->id . "'";
			$url3 = "'" . site_url('student_report_rgjj360/rgjj360_report/') . "?id=" . $student->id . "'";
			$row[] = '<a class="btn btn-sm btn-success" title="Info Report" onclick="info_report_new_tab(' . $url1 . ')"><i class="glyphicon glyphicon-file"></i> Details</a>
			<a class="btn btn-sm btn-primary" title="Attendance Report" onclick="info_report_new_tab(' . $url2 . ')"><i class="glyphicon glyphicon-file"></i> Attendance</a>
			<a class="btn btn-sm btn-success" title="RGJJ360 Report" onclick="info_report_new_tab(' . $url3 . ')"><i class="glyphicon glyphicon-file"></i> RGJJ360</a>';
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

public function save_download()
  {
		//load mPDF library
		$this->load->library('m_pdf');
		//load mPDF library


		//now pass the data//
		 $this->data['title']="MY PDF TITLE 1.";
		 $this->data['description']="";
		 $this->data['description']=$this->official_copies;
		 //now pass the data //


		$html=$this->load->view('pdf_output',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.

		//this the the PDF filename that user will get to download
		$pdfFilePath ="mypdfName-".time()."-download.pdf";


		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//generate the PDF!
		$pdf->WriteHTML($html,2);
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		$pdf->Output($pdfFilePath, "D");


  }
}
