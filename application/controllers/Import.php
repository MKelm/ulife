<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
  }

  public function perform($key = NULL)
  {
    if (!empty($key) && $key == $this->config->item("access_key"))
    {
      $data = array("import" => time());

      $this->load->model("import_model");
      $this->import_model->reset_database();

      $this->import_model->research_main_fields();
      $this->import_model->research_sub_fields();

      $this->import_model->buildings();
      $this->import_model->units();

      $this->import_model->set_user_start_units();

      $this->import_model->config();

      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($data));
    }
    else
      show_404();
  }

}