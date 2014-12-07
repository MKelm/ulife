<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Research_model extends CI_Model {

  private $_fields_table = "research_fields";

  private $_levels_table = "research_levels";

  private $_users_research_list = array();

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function load_users_research_list()
  {
    $this->load->model("user/user_research_model");
    $this->_users_research_list = $this->user_research_model->get_research_list(
      $this->session->userdata("user_id")
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

  public function get_fields_list(
                    $parent_id = 0,
                    $with_levels = TRUE, $with_user_entries = TRUE
                  )
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
      if ($with_user_entries === TRUE)
        $this->load_users_research_list();
      foreach ($fields_list as $id => $field)
      {
        $this->db->select(array("id", "number", "researchers", "experience"));
        $this->db->order_by("number", "asc");
        $query = $this->db->get_where(
          $this->_levels_table, array("field_id" => $id)
        );
        $fields_list[$id]["levels"] = array();
        foreach ($query->result() as $row)
        {
          $fields_list[$id]["levels"][$row->id] = array(
            "number" => $row->number,
            "researchers" => $row->researchers,
            "experience" => $row->experience,
            "user" => NULL
          );
          if ($with_user_entries === TRUE)
            $fields_list[$id]["levels"][$row->id]["user"] =
              $this->get_users_research_entry($id, $row->id);
        }
      }
    }
    return $fields_list;
  }

  public function start_research($field_id, $level_id)
  {
    //$researcherId = $this->_units->getUnitIdByName("researcher");
    //$researchersAmounts = $this->_user->getResearchersAmounts($researcherId);
    $researchers_amount["inactive"] = 10;

    $this->db->select(array("researchers"));
    $query = $this->db->get_where(
      $this->_levels_table, array("id" => $level_id, "field_id" => $field_id)
    );
    $researchers_needed = 0;
    foreach ($query->result() as $row)
    {
      $researchers_needed = $row->researchers;
    }
    if ($researchers_needed <= $researchers_amount["inactive"])
    {
      /*return $this->_user->updateResearch(
        $field_id, $level_id, $researchers_needed
      );*/
      return TRUE;
    }
    else
    {
      return FALSE;
    }
  }

  public function stop_research($field_id, $level_id)
  {
    //return $this->_user->updateResearch($field_id, $level_id, 0);
    return TRUE;
  }

}