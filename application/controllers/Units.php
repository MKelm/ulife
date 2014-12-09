<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Units extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->view->layout = "units";
    $this->view->title = "Einheiten - ";
    $this->load->model("units_model");
  }

  public function training($action = NULL, $unit_id = 0)
  {
    $data["action"] = $action;
    $data["action_status"] = FALSE;
    if ($action == "cancel" && $unit_id > 0)
    {
      $data["action_status"] = $this->units_model->release_unit($unit_id);
    }
    $data["units"] = $this->units_model->get_training_list();
    $this->_load_update_data($data);
    $this->view->title .= "Ausbildung";
    $this->view->data = $data;
    $this->view->page = "units/training";
    $this->view->load();
  }

  public function inventory($action = NULL, $unit_id = 0)
  {
    $data["action"] = $action;
    $data["action_status"] = FALSE;
    if ($action == "release" && $unit_id > 0)
    {
      $data["action_status"] = $this->units_model->release_unit($unit_id);
    }
    $this->_load_update_data($data);
    $data["units"] = $this->units_model->get_inventory_list();

    $this->view->title .= "Inventar";
    $this->view->data = $data;
    $this->view->page = "units/inventory";
    $this->view->load();
  }

  public function index()
  {
    $this->selection();
  }

  public function selection($action = NULL, $unit_id = 0, $level_id = 0)
  {
    $data["action"] = $action;
    $data["action_status"] = FALSE;
    if ($action == "train" && $unit_id > 0 && $level_id > 0)
    {
      $data["action_status"] = $this->units_model->train_unit(
        $unit_id, $level_id
      );
    }
    $this->_load_update_data($data);
    $data["units"] = $this->units_model->get_selection_list();
    $this->view->title .= "Auswahl";
    $this->view->data = $data;
    $this->view->page = "units/selection";
    $this->view->load();
  }

  private function _load_update_data(&$data) {
    $this->load->model("update_model");
    $update_config = $this->update_model->load_config();
    $data["round_number"] = $update_config["round_number"];
    $data["update_time"] = $update_config["update_time"];
    $data["update_interval"] = $update_config["update_interval"];
  }

}