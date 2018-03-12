<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_report_rgjj360 extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    // Load session library
    $this->load->library('session');
    $this->load->model('student_model','student');
    $this->load->model('attendance_model','attendance');

  }

    public function rgjj360_report()
    {
      $id = $_GET['id'];
      $sql = "SELECT * FROM `students` WHERE `id` = " . $id;
      $query = $this->db->query($sql);
      $row = $query->row_array();
      $studentName = $row['first'] . " " . $row['last'];

      $sql = "SELECT programs.ProgramName, attendance.classDate, attendance.classTime, attendance.lessonNumber FROM attendance INNER JOIN programs ON attendance.programID=programs.programID WHERE `studentID` = " . $id . " AND `lessonNumber` <> 'na'";

      $query = $this->db->query($sql);

      $html1 =
      "<html>
      <head>


      </head>
        <h1 >Royce Gracie JJ 360 Completed Lessons</h1>
      <hr size = \"10\"></hr>
      <h2>" . $studentName . "</h2>

      <table cellpadding=0 cellspacing=0 width=100% style=border: 1px; rules=none>
      <tr>
      <td><b>Class Name</b></td>
      <td><b>Date</b></td>
      <td><b>Time</b></td>
      <td><b>Lessons Completed</b></td>

      </tr>
      ";

      foreach ($query->result() as $row)
      {
        $html2 =
        "<tr>
          <td>" . $row->ProgramName . "</td>
          <td>" . $row->classDate .   "</td>
          <td>" . date('g:i A',$row->classTime) .   "</td>
          <td>" . $row->lessonNumber .   "</td>
        </tr>";

      }

      $html3 = "
      </table>
      </html>";

      $html = $html1 . $html2 . $html3;

      //echo $html;

      $mpdf = new \Mpdf\Mpdf();

      $mpdf->WriteHTML($html);
      $mpdf->Output(); // opens in browser
      $mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
    }

}
