<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

  private $_units_table = "users_units";

  private $_research_table = "users_research";

  private $_researchers_table = "users_researchers";

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  // RESEARCH STUFF

  public function get_research_list(
                    $user_id, $field_ids = NULL, $field_level_ids = NULL
                  )
  {
    $this->db->select(
      array("id", "field_id", "field_level_id", "experience", "rounds", "time")
    );
    $this->db->where("user_id", $user_id);
    if (count($field_ids) > 0)
      $this->db->where(
        sprintf("field_id IN ('%s')", implode("','", $field_ids))
      );
    if (count($field_level_ids) > 0)
      $this->db->where(
        sprintf("field_level_id IN ('%s')", implode("','", $field_level_ids))
      );
    $query = $this->db->get($this->_research_table);
    $research_list = array();
    foreach ($query->result() as $row)
    {
      $research_list[$row->id] = array(
        "id" => $row->id,
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

  public function update_research(
                    $user_id, $field_id, $field_level_id, $researchers_needed
                  ) {
      // re/start or stop research
      $research_list = $this->get_research_list(
        $user_id, array($field_id), array($field_level_id)
      );
      if ($researchers_needed > 0)
      {
        // todo select/set researchers from available list
        if (count($research_list) == 1)
        {
          $current_research = current($research_list);
          $data = array(
            // todo re-calc rest rounds by researchers
            "rounds" => $current_research["rounds"],
            "time" => time()
          );
          $this->db->where("id", $current_research["id"]);
          return $this->db->update($this->_research_table, $data);
        }
        else
        {
          $data = array(
            "user_id" => $user_id,
            "field_id" => $field_id,
            "field_level_id" => $field_level_id,
            "experience" => 0,
            "rounds" => 10, // todo calc rounds by researchers
            "time" => time()
          );
          return $this->db->insert($this->_research_table, $data);
        }
      }
      else if (count($research_list) == 1)
      {
        // pause research
        $current_research = current($research_list);
        $data = array(
          "time" => 0
        );
        $this->db->where("id", $current_research["id"]);
        return $this->db->update($this->_research_table, $data);
      }
    }
}