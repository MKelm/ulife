<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_research_model extends CI_Model {

  private $_research_table = "users_research";

  private $_researchers_table = "users_researchers";

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_research_list($user_id, $additional_conditions = NULL)
  {
    $this->db->select(
      array("id", "field_id", "field_level_id", "experience", "rounds", "time")
    );
    $conditions = array("user_id" => $user_id);
    if (is_array($additional_conditions))
    {
      foreach ($additional_conditions as $key => $value)
      {
        $conditions[$key] = $value;
      }
    }
    $query = $this->db->get_where($this->_research_table, $conditions);
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
}