<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_model extends CI_Model {

  public $field_errors = array();

  private $_current_password = NULL;
  private $_current_email = NULL;

  private $_users_table = "users";

  public function __construct()
  {
    parent::__construct();
    $this->load->library("form_validation");
    $this->form_validation->set_error_delimiters(
      "<div class=\"alert alert-danger\" role=\"alert\">", "</div>"
    );
  }

  private function _register_user($data) {
    $this->load->database();
    $registration_key = md5(microtime(TRUE).rand());
    $status = $this->db->insert(
      $this->_users_table,
      array(
        "name" => $data["name"],
        "email" => $data["email"],
        "password" => hash("sha256", $data["password"], FALSE),
        "wood" => $this->config->item("start_value_wood"),
        "stones" => $this->config->item("start_value_stones"),
        "food" => $this->config->item("start_value_food"),
        "coins" => $this->config->item("start_value_coins"),
        "citizen" => $this->config->item("start_value_citizen"),
        "experience" => $this->config->item("start_value_experience"),
        "registration" => $registration_key
      )
    );
    if ($status === TRUE)
    {
      $this->_current_email = $data["email"];
      return $registration_key;
    }
    return FALSE;
  }

  public function password_check($password) {
    $this->_current_password = $password;
    return TRUE;
  }

  public function password2_check($password) {
    if ($this->_current_password !== $password)
    {
      $this->form_validation->set_message(
        'external_callbacks', 'Wrong password in {field} field.'
      );
      return FALSE;
    }
    return TRUE;
  }

  public function verify_registration()
  {
    $this->form_validation->set_rules(
      'name', 'Name',
      'trim|required|xss_clean'
    );
    $this->form_validation->set_rules(
      'email', 'E-Mail',
      'trim|required|xss_clean|valid_email'
    );
    $this->form_validation->set_rules(
      'password', 'Passwort', 'trim|required|xss_clean|'.
      'external_callbacks[account/registration_model,password_check]'
    );
    $this->form_validation->set_rules(
      'password2', 'Passwort bestätigen', 'trim|required|xss_clean|'.
      'external_callbacks[account/registration_model,password2_check]'
    );

    if ($this->form_validation->run() == FALSE)
    {
      $this->field_errors = $this->form_validation->error_array();
      return FALSE;
    }
    else
    {
      $registration_key = $this->_register_user($this->input->post(NULL, TRUE));
      if ($registration_key !== FALSE)
      {
        $confirmation_link = base_url()."account/confirmation/".$registration_key;
        $this->session->set_flashdata("registration_status", TRUE);
        $this->session->set_flashdata("confirmation_link", $confirmation_link);
      }
      return $confirmation_link ;
    }
  }

  public function get_email() {
    return $this->_current_email;
  }

  public function get_status()
  {
    $status = $this->session->flashdata("registration_status");
    return $status === TRUE;
  }

  public function get_confirmation_link()
  {
    if ($this->config->item("send_confirmation_email") == FALSE) {
      return $this->session->flashdata("confirmation_link");
    }
    return NULL;
  }

  public function confirm($key) {
    $this->load->database();
    $this->db->select("id");
    $query = $this->db->get_where(
      $this->_users_table, array("registration" => $key)
    );
    foreach ($query->result() as $row)
    {
      if ($row->id > 0)
      {
        $this->db->where("id", $row->id);
        return $this->db->update(
          $this->_users_table, array("registration" => time())
        );
      }
    }
    return FALSE;
  }

}