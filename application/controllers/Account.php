<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function registration()
  {
    $this->load->model("account/registration_model");
    $confirmation_link = $this->registration_model->verify_registration();
    if ($confirmation_link !== FALSE)
    {
      if ($this->config->item("send_regc_email") == TRUE)
      {
        $this->load->library("email");
        $this->email->from(
          $this->config->item("regc_email_from_addr"),
          $this->config->item("regc_email_from_name")
        );
        $this->email->to($this->registration_model->get_email());
        $this->email->subject($this->config->item("regc_email_subject"));
        $this->email->message(
          $this->config->item("regc_email_text").$confirmation_link
        );
        $this->email->send();
      }
      redirect("account/registration");
    }

    $data["field_errors"] = $this->registration_model->field_errors;
    $data["registration_status"] = $this->registration_model->get_status();
    $data["confirmation_link"] = $this->registration_model->get_confirmation_link();
    $data["confirmation_status"] = NULL;

    $this->view->has_form = TRUE;
    $this->view->data = $data;
    $this->view->title = "Registrierung";
    $this->view->page = "account/registration";
    $this->view->load();
  }

  public function confirmation($key) {
    $this->load->model("account/registration_model");

    $data["field_errors"] = array();
    $data["registration_status"] = NULL;
    $data["confirmation_status"] = $this->registration_model->confirm($key);

    $this->view->has_form = TRUE;
    $this->view->data = $data;
    $this->view->title = "Registrierung";
    $this->view->page = "account/registration";
    $this->view->load();
  }

  public function login()
  {
    $this->load->model("account/login_model");
    $valid_user = $this->login_model->verify_login();
    if ($valid_user === TRUE)
      redirect("");

    $data["field_errors"] = $this->login_model->field_errors;

    $this->view->has_form = TRUE;
    $this->view->data = $data;
    $this->view->title = "Anmeldung";
    $this->view->page = "account/login";
    $this->view->load();
  }

  public function logout()
  {
    $this->load->model("account/login_model");
    $this->login_model->disable_login();
    redirect("");
  }
}