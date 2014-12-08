<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_model extends CI_Model {

  private $_config_table = "config";
  private $_users_table = "users";
  private $_users_buildings_table = "users_buildings";
  private $_users_units_table = "users_units";
  private $_users_research_table = "users_research";

  private $_config = array();

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
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

  public function update_research($round_amount)
  {
    $users_research = array();
    $this->db->select(array("id", "rounds"));
    $this->db->where("rounds >", 0);
    $this->db->from($this->_users_research_table);
    $query = $this->db->get();
    foreach ($query->result() as $row)
      $users_research[$row->id] = $row->rounds;

    foreach ($users_research as $id => $rounds)
    {
      $rounds_to_go = $rounds - $round_amount;
      if ($rounds_to_go > 0) {
        // update
        $this->db->where("id", $id);
        $this->db->update(
          $this->_users_research_table, array("rounds" => $rounds_to_go)
        );
      } else {
        if ($rounds_to_go < 0) {
          $time = time() + $rounds_to_go * $this->_config["update_interval"];
        } else {
          $time = time();
        }
        // final update
        $this->db->where("id", $id);
        $this->db->update(
          $this->_users_research_table,
          array("rounds" => 0, "time" => $time)
        );
      }
    }
  }

}