<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_units_model extends CI_Model {

  private $_table = "users_units";

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
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