<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buildings extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->view->layout = "buildings";
    $this->view->title = "Gebäude - ";
  }

  public function construction()
  {
    $data = array();
    $this->view->data = $data;
    $this->view->page = "buildings/construction";
    $this->view->load();
  }

  public function inventory()
  {
    $data = array();
    $this->view->data = $data;
    $this->view->page = "buildings/inventory";
    $this->view->load();
  }

  public function index()
  {
    $this->selection();
  }

  public function selection($action = NULL)
  {
    $this->load->model("buildings_model");

    $data = array(
      "action" => $action,
      "action_status" => FALSE,
      "buildings" => $this->buildings_model->get_selection_list()
    );
    $this->view->data = $data;
    $this->view->page = "buildings/selection";
    $this->view->load();
  }

}