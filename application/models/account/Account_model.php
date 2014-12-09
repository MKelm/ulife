<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {

  private $_users_table = "users";

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function change_coins($user_id, $amount)
  {
    $user_data = $this->get_user_data($user_id);
    $this->db->where("id", $user_id);
    if (isset($user_data["coins"]) && $user_data["coins"] + $amount >= 0)
    {
      return $this->db->update(
        $this->_users_table, array("coins" => $user_data["coins"] + $amount)
      );
    }
    return FALSE;
  }

  public function get_user_data($user_id)
  {

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