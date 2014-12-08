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

}