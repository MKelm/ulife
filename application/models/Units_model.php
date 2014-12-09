<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Units_model extends CI_Model {

  private $_table = "units";

  private $_levels_table = "units_levels";

  private $_users_research_table = "users_research";

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_selection_list($with_levels = TRUE, $research_dependency = TRUE)
  {
    $list = array();
    $this->db->select(array("id", "name", "title", "text"));
    $this->db->from($this->_table);
    $this->db->order_by("title", "asc");
    $query = $this->db->get();
    foreach ($query->result() as $row)
    {
      $list[$row->id] = array(
        "id" => $row->id,
        "name" => $row->name,
        "title" => $row->title,
        "text" => $row->text
      );
    }
    if (count($list) > 0 && $with_levels == TRUE)
    {
      foreach ($list as $id => $building)
      {
        $list[$id]["levels"] = array();
        $this->db->select(
          array(
            "ul.id", "ul.number", "ul.r_level_id", "ul.t_coins", "ul.t_rounds", "ul.volume"
          )
        );
        $this->db->from($this->_levels_table." as ul");
        if ($research_dependency === TRUE)
          $this->db->join(
            $this->_users_research_table." as ur",
            "ur.field_level_id = ul.r_level_id AND ur.start_round = 0",
            "inner"
          );

        $this->db->order_by("ul.number", "asc");
        $this->db->where("ul.unit_id", $id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
          $list[$id]["levels"][$row->id] = array(
            "id" => $row->id,
            "number" => $row->number,
            "r_level_id" => $row->r_level_id,
            "t_coins" => $row->t_coins,
            "t_rounds" => $row->t_rounds,
            "volume" => $row->volume
          );
        }
        if (count($list[$id]["levels"]) == 0 ||
            empty($list[$id]["levels"][$row->id]))
          unset($list[$id]);
      }
    }
    return $list;
  }

  public function get_training_list()
  {
    $units = $this->get_selection_list(TRUE);
    $this->load->model("units/users_units_model", "user_model");
    $training_units = $this->user_model->get_units_list(
      $this->session->userdata("user_id"), TRUE
    );
    if (count($training_units) > 0)
    {
      foreach ($training_units as $id => $value)
      {
        if (isset($units[$value["unit_id"]]) &&
            isset($units[$value["unit_id"]]["levels"][$value["level_id"]]))
        {
          $training_units[$id]["title"] = $units[$value["unit_id"]]["title"];
          $training_units[$id]["text"] = $units[$value["unit_id"]]["text"];
          $training_units[$id]["number"] =
            $units[$value["unit_id"]]["levels"][$value["level_id"]]["number"];
          $training_units[$id]["t_rounds"] =
            $units[$value["unit_id"]]["levels"][$value["level_id"]]["t_rounds"];
          $training_units[$id]["volume"] =
            $units[$value["unit_id"]]["levels"][$value["level_id"]]["volume"];
        }
      }
    }
    return $training_units;
  }

  public function get_inventory_list()
  {
    $units = $this->get_selection_list(TRUE, FALSE);
    $this->load->model("units/users_units_model", "user_model");
    $inventory_units = $this->user_model->get_units_list(
      $this->session->userdata("user_id"), FALSE
    );
    if (count($inventory_units) > 0)
    {
      foreach ($inventory_units as $id => $value) {
        if (isset($units[$value["unit_id"]]) &&
            isset($units[$value["unit_id"]]["levels"][$value["level_id"]]))
        {
          $inventory_units[$id]["title"] = $units[$value["unit_id"]]["title"];
          $inventory_units[$id]["text"] = $units[$value["unit_id"]]["text"];
          $inventory_units[$id]["number"] =
            $units[$value["unit_id"]]["levels"][$value["level_id"]]["number"];
          $inventory_units[$id]["volume"] =
            $units[$value["unit_id"]]["levels"][$value["level_id"]]["volume"];
        }
      }
    }
    return $inventory_units;
  }

  public function train_unit($id, $level_id)
  {
    $result = TRUE;
    $units = $this->get_selection_list(TRUE);
    if (isset($units[$id]) && isset($units[$id]["levels"][$level_id]))
    {
      $level_details = $units[$id]["levels"][$level_id];
      $this->load->model("units/users_units_model", "user_model");
      /*$result = $result && $this->user_model->change_coins(
        -1 * $level_details["t_coins"]
      );
      $result = $result && $this->user_model->add_unit(
        $id, $level_id, $level_details["t_rounds"]
      );*/
    }
    else
    {
      $result = FALSE;
    }
    return $result;
  }

  public function release_unit($user_unit_id)
  {
    $this->load->model("units/users_units_model", "user_model");
    return $this->user_model->delete_unit(
      $this->session->userdata("user_id"), $user_unit_id
    );
  }

  public function get_unit_id_by_name($name)
  {
    $this->db->select(array("id"));
    $query = $this->db->get_where(
      $this->_table, array("name" => $name)
    );
    foreach ($query->result() as $row)
    {
      return $row->id;
    }
    return NULL;
  }

  public function get_unit_volume($unit_id, $unit_level_id) {
    $this->db->select(array("volume"));
    $query = $this->db->get_where(
      $this->_levels_table,
      array("id" => $unit_level_id, "unit_id" => $unit_id)
    );
    foreach ($query->result() as $row)
    {
      return $row->volume;
    }
    return NULL;
  }

}
