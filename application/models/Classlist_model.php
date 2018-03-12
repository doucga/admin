<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classlist_model extends CI_Model {

	var $table = 'students';
	var $column_order = array('first','last','classTime',null); //set column field database for datatable orderable
	var $column_search = array('first','last','classTime'); //set column field database for datatable searchable just firstname , lastname are searchable
	var $order = array('first' => 'asc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{

		$this->db->from($this->table);

		$i = 0;

		foreach ($this->column_search as $item) // loop column
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{

				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->load->helper('url');
		$programID = $this->uri->segment(3);
		$this->db->select('students.first, students.last, attendance.classDate, attendance.classTime, attendance.programID');
		$this->db->from('students');
		$this->db->join('attendance', 'students.id = attendance.studentID', 'INNER');
		$where = "programID='" . $programID . "' AND classDate='" . date('Y-m-d') . "'";
		$this->db->where($where);
		$this->db->order_by('students.first','asc');
		$query = $this->db->get();
		//$data = $query->row_array();
		//echo json_encode($data);



		//$this->_get_datatables_query();
		//if($_POST['length'] != -1)
		//$this->db->limit($_POST['length'], $_POST['start']);
		//$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_program_name($id)
	{
		$this->load->helper('url');
		$programID = $this->uri->segment(3);
		$query = $this->db->query("SELECT ProgramName FROM programs WHERE programID=".$programID.";");
		$query = $this->db->get();

		return $query->row();
	}

	public function get_programs($id)
	{
		$query = $this->db->query("select distinct ProgramName from programs;");
		$query = $this->db->get();
		return $query->row();
	}
	function get_student_datatables()
	{
		$this->load->helper('url');
		$this->db->select('students.first, students.last');
		$this->db->from('students');
		$this->db->order_by('students.first','asc');
		$query = $this->db->get();

		return $query->result();
	}
}
