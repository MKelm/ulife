<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

  public $field_errors = array();

  private $_current_user_name = NULL;

  private $_current_user_id = NULL;

  private $_users_table = "users";

  public function __construct()
  {
    parent::__construct();
    $this->load->library("form_validation");
    $this->form_validation->set_error_delimiters(
      "<div class=\"alert alert-danger\" role=\"alert\">", "</div>"
    );
  }

  public function name_check($name) {
    $this->db->select("id");
    $query = $this->db->get_where(
      $this->_users_table, array("name" => $name)
    );
    foreach ($query->result() as $row)
    {
      if ($row->id > 0)
      {
        $this->_current_user_id = $row->id;
        $this->_current_user_name = $name;
        return TRUE;
      }
    }
    $this->form_validation->set_message(
      'external_callbacks', 'Wrong user name in {field} field.'
    );
    return FALSE;
  }

  public function password_check($password) {
    if (!empty($this->_current_user_name)) {
      $this->db->select("id");
      $query = $this->db->get_where(
        $this->_users_table,
        array(
          "name" => $this->_current_user_name,
          "password" => hash("sha256", $password, FALSE)
        )
      );
      foreach ($query->result() as $row)
      {
        if ($row->id > 0)
        {
          return TRUE;
        }
      }
      $this->form_validation->set_message(
        'external_callbacks', 'Wrong password in {field} field.'
      );
      return FALSE;
    }
    return TRUE;
  }

  function verify_login()
  {
    $this->form_validation->set_rules(
      'name', 'Name',
      'trim|required|xss_clean|'.
      'external_callbacks[account/login_model,name_check]'
    );
    $this->form_validation->set_rules(
      'password', 'Passwort', 'trim|required|xss_clean|'.
      'external_callbacks[account/login_model,password_check]'
    );

    if ($this->form_validation->run() == FALSE) {
      $this->field_errors = $this->form_validation->error_array();
      return FALSE;
    } else {
      $this->session->set_userdata("valid_user", TRUE);
      $this->session->set_userdata("user_name", $this->_current_user_name);
      $this->session->set_userdata("user_id", $this->_current_user_id);
      return TRUE;
    }
  }

  function disable_login()
  {
    $this->session->set_userdata("valid_user", FALSE);
    $this->session->set_userdata("user_name", NULL);
    $this->session->set_userdata("user_id", NULL);
  }

}