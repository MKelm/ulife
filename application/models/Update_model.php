<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends CI_Model {

  private $_config_table = "config";
  private $_users_table = "users";
  private $_users_buildings_table = "users_buildings";
  private $_users_units_table = "users_units";
  private $_users_research_table = "users_research";
  private $_users_researchers_table = "users_researchers";

  private $_config = array();

  public function __construct()
  {
    parent::__construct();
  }

  public function load_config()
  {
    $this->_config = array();
    $this->db->select(array("name", "value"));
    $this->db->from($this->_config_table);
    $query = $this->db->get();
    foreach ($query->result() as $row)
    {
      $this->_config[$row->name] = $row->value;
    }
    $this->_config["update_interval"] = $this->config->item("update_interval");
    return $this->_config;
  }

  public function set_config($name, $value)
  {
    $this->_config[$name] = $value;
  }

  public function save_config()
  {
    $result = TRUE;
    foreach ($this->_config as $name => $value)
    {
      $this->db->where("name", $name);
      $result = $result && $this->db->update(
        $this->_config_table, array("value" => $value)
      );
    }
    return $result;
  }

  public function get_users_amount() {
    return $this->db->count_all_results($this->_users_table);
  }

  public function update_research()
  {
    $finished_research = array();
    $this->db->select(array("id"));
    $this->db->where("start_round >", 0);
    $this->db->where("end_round <=", $this->_config["round_number"]);
    $this->db->from($this->_users_research_table);
    $query = $this->db->get();
    foreach ($query->result() as $row)
    {
      $finished_research[] = $row->id;
    }

    foreach ($finished_research as $id)
    {
      // final update
      $this->db->where("id", $id);
      $this->db->update(
        $this->_users_research_table,
        array("start_round" => 0)
      );
      // free researchers
      $result = $this->db->delete(
        $this->_users_researchers_table,
        array("research_id" => $id)
      );
    }
  }

  public function update_units()
  {

    $finished_training = array();
    $this->db->select(array("id"));
    $this->db->where("start_round >", 0);
    $this->db->where("end_round <=", $this->_config["round_number"]);
    $this->db->from($this->_users_units_table);
    $query = $this->db->get();
    foreach ($query->result() as $row)
    {
      $finished_training[] = $row->id;
    }

    foreach ($finished_training as $id)
    {
      // final update
      $this->db->where("id", $id);
      $this->db->update(
        $this->_users_units_table,
        array("start_round" => 0)
      );
    }
  }

}