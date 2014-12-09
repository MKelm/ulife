<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_units_model extends CI_Model {

  private $_table = "users_units";
  private $_researchers_table = "users_researchers";
  private $_builders_table = "users_builders";

  public function __construct()
  {
    parent::__construct();
  }

  public function pay_unit($user_id, $coins)
  {
    $this->load->model("account/account_model");
    return $this->account_model->change_coins($user_id, -1 * $coins);
  }

  public function add_unit($user_id, $unit_id, $level_id, $rounds)
  {
    $this->load->model("update_model");
    $update_config = $this->update_model->load_config();
    return $this->db->insert(
      $this->_table,
      array(
        "user_id" => $user_id,
        "unit_id" => $unit_id,
        "level_id" => $level_id,
        "start_round" => $update_config["round_number"] + 1,
        "end_round" => $update_config["round_number"] + 1 + $rounds
      )
    );
  }

  public function delete_unit($user_id, $user_unit_id)
  {
    // check if unit is used in research / build process
    $this->db->from($this->_researchers_table);
    $this->db->where(array("unit_id" => $user_unit_id));
    if ($this->db->count_all_results() > 0)
      return FALSE;

    $this->db->from($this->_builders_table);
    $this->db->where(array("unit_id" => $user_unit_id));
    if ($this->db->count_all_results() > 0)
      return FALSE;

    return $this->db->delete(
      $this->_table, array("user_id" => $user_id, "id" => $user_unit_id)
    );
  }

  public function get_units_list($user_id, $in_training = FALSE) {
    $units = array();
    $conditions = array("user_id" => $user_id);
    if ($in_training == TRUE) {
      $conditions["start_round >"] = 0;
    } else {
      $conditions["start_round"] = 0;
    }
    $this->db->select(
      array("id", "unit_id", "level_id", "start_round", "end_round")
    );
    $this->db->order_by("end_round", "desc");
    $query = $this->db->get_where(
      $this->_table, $conditions
    );
    foreach ($query->result() as $row)
    {
      $units[$row->id] = array(
        "id" => $row->id,
        "unit_id" => $row->unit_id,
        "level_id" => $row->level_id,
        "start_round" => $row->start_round,
        "end_round" => $row->end_round
      );
    }
    return $units;
  }
}