<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function registration()
  {
    $this->view->has_form = TRUE;
    $this->view->title = "Registrierung";
    $this->view->page = "account/registration";
    $this->view->load();
  }

  public function login()
  {
    $this->load->model("account/login_model");
    $this->login_model->verify_login();
    $data["field_errors"] = $this->login_model->field_errors;

    $this->view->has_form = TRUE;
    $this->view->data = $data;
    $this->view->title = "Anmeldung";
    $this->view->page = "account/login";
    $this->view->load();
  }
}