<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_report_attendance extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    // Load session library
    $this->load->library('session');
    $this->load->model('student_model','student');
    $this->load->model('attendance_model','attendance');

  }

    public function attendance_report()
    {
      $id = $_GET['id'];
      $sql = "SELECT * FROM `students` WHERE `id` = " . $id;
      $query = $this->db->query($sql);
      $row = $query->row_array();
      $studentName = $row['first'] . " " . $row['last'];

      $sql = "SELECT programs.ProgramName, programs.starttime, attendance.classDate, attendance.classTime, attendance.lessonNumber FROM attendance INNER JOIN programs ON attendance.programID=programs.programID WHERE `studentID` = " . $id ;

      $query = $this->db->query($sql);


      $html1 =
      "<html>
      <head>


      </head>
        <h1 >Student Attendance Report</h1>
      <hr size = \"10\"></hr>
      <h2>" . $studentName . "</h2>

      <table cellpadding=0 cellspacing=0 width=100% style=border: 1px; rules=none>
      <tr>
      <td><b>Class Name</b></td>
      <td><b>Date</b></td>
      <td><b>Start Time</b></td>
      <td><b>Checked in Time</b></td>

      </tr>
      ";
      $htmlrows = "";

      foreach ($query->result() as $row)
      {
        $html2 =
        "<tr>
          <td>" . $row->ProgramName . "</td>
          <td>" . $row->classDate .   "</td>
          <td>" . date('g:i A',strtotime($row->starttime)) .   "</td>
          <td>" . date('g:i A',$row->classTime) .   "</td>
        </tr>";

        $htmlrows = $htmlrows . $html2;

      }

      $html3 = "
      </table>
      </html>";

      $html = $html1 . $htmlrows . $html3;

      //echo $html;

      $mpdf = new \Mpdf\Mpdf();

      $mpdf->WriteHTML($html);
      $mpdf->Output(); // opens in browser
      //$mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
    }

}
