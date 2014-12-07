<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

  private $_units_table = "users_units";

  private $_research_table = "users_research";

  private $_researchers_table = "users_researchers";

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_research_list($user_id, $field_ids = NULL)
  {
    $this->db->select(
      array("id", "field_id", "field_level_id", "experience", "rounds", "time")
    );
    $this->db->where("user_id", $user_id);
    if (count($field_ids) > 0)
      $this->db->where(
        sprintf("field_id IN ('%s')", implode("','", $field_ids))
      );
    $query = $this->db->get($this->_research_table);
    $research_list = array();
    foreach ($query->result() as $row)
    {
      $fields_list[$row->id] = array(
        "field_id" => $row->field_id,
        "field_level_id" => $row->field_level_id,
        "experience" => $row->experience,
        "rounds" => $row->rounds,
        "time" => $row->time
      );
    }
    return $research_list;
  }

  public function get_researchers_amount($user_id, $researcher_id)
  {
    $this->db->where("user_id", $user_id);
    $this->db->where("unit_id", $researcher_id);
    $this->db->where("rounds", 0);
    $this->db->from($this->_units_table);
    $all_amount = $this->db->count_all_results();

    $this->db->where("user_id", $user_id);
    $this->db->where("unit_id", $researcher_id);
    $this->db->from($this->_researchers_table);
    $active_amount = $this->db->count_all_results();

    return array(
      "active" => $active_amount,
      "inactive" => $all_amount - $active_amount
    );
  }
}