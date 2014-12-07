<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_model extends CI_Model {

  private $_units_table = "units";

  private $_units_levels_table = "units_levels";

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_unit_id_by_name($name)
  {
    $this->db->select(array("id"));
    $query = $this->db->get_where(
      $this->_units_table, array("name" => $name)
    );
    foreach ($query->result() as $row)
    {
      return $row->id;
    }
    return NULL;
  }

}
