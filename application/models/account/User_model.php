<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

  private $_users_table = "users";

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_data($user_id) {

    $query = $this->db->get_where($this->_users_table, array("id" => $user_id));
    foreach ($query->result() as $row)
    {
      if ($row->id == $user_id)
      {
        return array(
          "id" => $row->id,
          "name" => $row->name,
          "email" => $row->email,
          "rtime" => $row->registration, // registration time
          "wood" => $row->wood,
          "stones" => $row->stones,
          "food" => $row->food,
          "coins" => $row->coins,
          "citizen" => $row->citizen,
          "experience" => $row->experience
        );
      }
    }
    return NULL;
  }
}