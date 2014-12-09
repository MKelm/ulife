<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research_model extends CI_Model {

  private $_fields_table = "research_fields";

  private $_levels_table = "research_levels";

  private $_users_research_list = array();

  private $_update_config = array();

  public function __construct()
  {
    parent::__construct();
  }

  public function set_update_config($update_config = NULL)
  {
    if (!empty($update_config))
    {
      $this->_update_config = $update_config;
    }
    else
    {
      $this->load->model("update_model");
      $this->_update_config = $this->update_model->load_config();
    }
  }

  public function load_users_research_list($field_ids = NULL)
  {
    $this->load->model("research/users_research_model", "users_model");
    $this->users_model->set_update_config($this->_update_config);
    $this->_users_research_list = $this->users_model->get_research_list(
      $this->session->userdata("user_id"), $field_ids
    );
  }

  public function get_users_research_entry($field_id, $level_id)
  {
    foreach ($this->_users_research_list as $entry) {
      if ($field_id == $entry["field_id"] && $level_id == $entry["field_level_id"])
      {
        return $entry;
      }
    }
    return array();
  }

  public function get_users_finished_research_levels($field_id, $full_data = FALSE)
  {
    $result = array();

    foreach ($this->_users_research_list as $entry) {
      if ($field_id == $entry["field_id"] &&
          $entry["end_round"] <= $this->_update_config["round_number"])
      {
        if ($full_data)
          $result[] = $entry;
        else
          $result[] = $entry["field_level_id"];
      }
    }
    return $result;
  }

  // get current max level number by parent research field level
  public function get_fields_level_max_number($parent_id, $field_ids = array())
  {
    if (!empty($field_ids))
      $this->load_users_research_list($field_ids);
    $max_number = 0;
    $user_finished_parent_research_levels =
      $this->get_users_finished_research_levels($parent_id);
    if (!empty($user_finished_parent_research_levels))
    {
      $this->db->from($this->_levels_table);
      $this->db->select("max(number) as max_number");
      $this->db->where_in("id", $user_finished_parent_research_levels);
      $query = $this->db->get();
      foreach ($query->result() as $row)
        $max_number = $row->max_number;
    }
    return $max_number;
  }

  // research fields list for user view
  public function get_fields_list($parent_id = 0, $with_levels = TRUE)
  {
    $this->db->select(array("id", "parent_id", "name", "title", "text"));
    $this->db->order_by("title", "asc");
    $query = $this->db->get_where(
      $this->_fields_table, array("parent_id" => $parent_id)
    );
    $fields_list = array();
    foreach ($query->result() as $row)
    {
      $fields_list[$row->id] = array(
        "parent_id" => $row->parent_id,
        "name" => $row->name,
        "title" => $row->title,
        "text" => $row->text
      );
    }
    if (count($fields_list) > 0 && $with_levels === TRUE)
    {
      $field_ids = array_keys($fields_list);
      if ($parent_id > 0)
        $field_ids[] = $parent_id;
      $this->load_users_research_list($field_ids);
      if ($parent_id > 0)
        $max_number = $this->get_fields_level_max_number($parent_id);

      foreach ($fields_list as $id => $field)
      {
        $user_finished_research_levels =
          $this->get_users_finished_research_levels($id);

        $this->db->select(array("id", "number", "researchers", "experience"));
        $this->db->order_by("number", "asc");
        $this->db->where("field_id", $id);
        if (isset($max_number))
          $this->db->where("number <=", $max_number);

        if (count($user_finished_research_levels) > 0)
          $this->db->where_not_in("id", $user_finished_research_levels);
        $query = $this->db->get($this->_levels_table, 1);
        $fields_list[$id]["levels"] = array();
        foreach ($query->result() as $row)
        {
          $fields_list[$id]["levels"][$row->id] = array(
            "number" => $row->number,
            "researchers" => $row->researchers,
            "experience" => $row->experience,
            "user" => $this->get_users_research_entry($id, $row->id)
          );
        }
        if (count($fields_list[$id]["levels"]) == 0 ||
            empty($fields_list[$id]["levels"][$row->id]))
          unset($fields_list[$id]);
      }
    }
    return $fields_list;
  }

  public function start_research($field_id, $level_id)
  {
    $this->load->model("research/users_research_model", "users_model");
    $this->users_model->set_update_config($this->_update_config);
    $researchers_amount = $this->users_model->get_researchers_amount(
      $this->session->userdata("user_id")
    );

    $researchers_needed = 0;
    $experience_needed = 0;
    $this->db->select(array("researchers", "experience"));
    $query = $this->db->get_where(
      $this->_levels_table, array("id" => $level_id, "field_id" => $field_id)
    );
    foreach ($query->result() as $row)
    {
      $researchers_needed = $row->researchers;
      $experience_needed = $row->experience;
    }

    if ($researchers_needed <= $researchers_amount["inactive"])
    {
      return $this->users_model->update_research(
        $this->session->userdata("user_id"),
        $field_id, $level_id, $researchers_needed, $experience_needed
      );
    }
    return FALSE;
  }

  public function cancel_research($field_id, $level_id)
  {
    $this->load->model("research/users_research_model", "users_model");
    $this->users_model->set_update_config($this->_update_config);
    return $this->users_model->update_research(
      $this->session->userdata("user_id"), $field_id, $level_id, 0, 0
    );
  }

}