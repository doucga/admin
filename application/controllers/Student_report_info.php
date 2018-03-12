<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_report_info extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    // Load session library
    $this->load->library('session');
    $this->load->model('student_model','student');

  }

    public function info_report()
    {
      $id = $_GET['id'];
      $sql = "SELECT * FROM `students` WHERE `id` = " . $id;
      $query = $this->db->query($sql);
      $row = $query->row_array();

      $html =
      "<html>
      <head>


      </head>
        <h1 >Student Information</h1>
      <hr size = \"10\"></hr>
      <h2>" . $row['first'] . " " . $row['last'] . "</h2>

      <table>
      <tr>
        <td>Home Phone:</td>
        <td><b>" . $row['phone'] . "</b></td>
      </tr>
      <tr>
        <td>Mobile Phone:</td>
        <td><b>" . $row['mobile'] . "</b></td>
      </tr>
      <tr>
        <td>Email Address:</td>
        <td><b>" . $row['email'] . "</b></td>
      </tr>
      <tr>
        <td>Care Card Number:</td>
        <td><b>" . $row['carecard'] . "</b></td>
      </tr>
      <tr>
        <td>Emergency Contact:</td>
        <td><b>" . $row['emergcontact'] . "</b></td>
      </tr>
      <tr>
        <td>Emergency Relationship:</td>
        <td><b>" . $row['emergeRelation'] . "</b></td>
      </tr>
      <tr>
        <td>Emergency Phone:</td>
        <td><b>" . $row['emergphone'] . "</b></td>
      </tr>
      <tr>
        <td>Emergency Mobile:</td>
        <td><b>" . $row['emergemobile'] . "</b></td>
      </tr>
      <tr>
        <td>RGJJ 360 Complete:</td>
        <td><b>" . $row['rgjjlessonscomplete'] . "</b></td>
      </tr>
      <tr>
        <td>Subscription:</td>
        <td><b>" . $row['subscription'] . "</b></td>
      </tr>
      <tr>
        <td>Punches Remaining:</td>
        <td><b>" . $row['punches'] . "</b></td>
      </tr>
      <tr>
        <td>Start Date:</td>
        <td><b>" . $row['startdate'] . "</b></td>
      </tr>
      <tr>
        <td>Paid to Date:</td>
        <td><b>" . $row['paidtodate'] . "</b></td>
      </tr>
      <tr>
        <td>Student Status:</td>
        <td><b>" . $row['status'] . "</b></td>
      </tr>
      </table>

    </html>";

      //echo $html;
      //$html = $this->load->view('student_report_info_view',[],true);
      $mpdf = new \Mpdf\Mpdf();

      $mpdf->WriteHTML($html);
      $mpdf->Output(); // opens in browser
      $mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
    }

}
