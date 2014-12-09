<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buildings_model extends CI_Model {

  private $_table = "buildings";

  private $_levels_table = "buildings_levels";

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_selection_list($with_levels = TRUE)
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
            "id", "number", "r_level_id", "c_wood", "c_stones", "c_workers",
            "c_rounds", "volume"
          )
        );
        $this->db->from($this->_levels_table);
        $this->db->order_by("number", "asc");
        $this->db->where("building_id", $id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
          $list[$id]["levels"][$row->id] = array(
            "id" => $row->id,
            "number" => $row->number,
            "r_level_id" => $row->r_level_id,
            "c_wood" => $row->c_wood,
            "c_stones" => $row->c_stones,
            "c_workers" => $row->c_workers,
            "c_rounds" => $row->c_rounds,
            "volume" => $row->volume
          );
        }
      }
    }
    return $list;
  }
}