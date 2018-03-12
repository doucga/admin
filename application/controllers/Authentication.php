<?php
// session_start(); //we need to start session in order to access it through CI
Class Authentication extends CI_Controller {

public function __construct() {
parent::__construct();

// Load form helper library
$this->load->helper('form');

// Load form validation library
$this->load->library('form_validation');

// Load session library
$this->load->library('session');

// Load database
$this->load->model('student_model');
}

// Show login page
public function index() {
$this->load->view('login_form');
}

// Check for user login process
public function user_login_process() {

$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) {
if(isset($this->session->userdata['logged_in'])){
  $this->load->helper('url');
  $this->load->view('partial/header');
  $this->load->view('home_view');
  $this->load->view('partial/footer');
}else{
$this->load->view('login_form');
}
} else {
$data = array(
'username' => $this->input->post('username'),
'password' => $this->input->post('password'),
);
$result = $this->student_model->login($data);
if ($result == TRUE) {

$username = $this->input->post('username');
$result = $this->student_model->read_user_information($username);
if ($result != false) {
$session_data = array(
'username' => $result[0]->user_name,
'usertype' => $result[0]->user_type,
);
// Add user data in session
$this->session->set_userdata('logged_in', $session_data);
$this->load->helper('url');
$this->load->view('partial/header');
$this->load->view('home_view');
$this->load->view('partial/footer');
}
} else {
$data = array(
'error_message' => 'Invalid Username or Password'
);
$this->load->view('login_form', $data);
}
}
}

// Logout from admin page
public function logout() {
// Removing session data
$sess_array = array(
'username' => ''
);
$this->session->unset_userdata('logged_in', $sess_array);
$data['message_display'] = '';
$this->load->view('login_form', $data);
}
}
?>
