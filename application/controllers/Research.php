<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->view->layout = "research";
    $this->view->title = "Forschung - ";
  }

  public function index()
  {
    $this->fields();
  }

  public function fields($selected_field_id = 0)
  {
    $this->load->model("research_model");
    $this->research_model->get_fields_list();

    $data["selected_field_id"] = $selected_field_id;
    $data["main_research_fields"] = $this->research_model->get_fields_list(
      0, $selected_field_id == NULL
    );
    if ($selected_field_id == NULL)
      $data["research_fields"] = $data["main_research_fields"];
    else
      $data["research_fields"] = $this->research_model->get_fields_list(
        $selected_field_id, TRUE
      );

    $this->view->data = $data;
    $this->view->title .= "Allgemein";
    $this->view->page = "research/fields";
    $this->view->load();
  }

}