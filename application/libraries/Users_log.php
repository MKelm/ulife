<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define("LOG_LEVEL_SUCCESS", 0);
define("LOG_LEVEL_INFO", 1);
define("LOG_LEVEL_WARNING", 2);
define("LOG_LEVEL_DANGER", 3);

class Users_log {

  private $CI;

  private $_log_table = "users_log";

  private $_messages = array();

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->CI->load->helper("output");
  }

  private function _save_message($level, $text, $time)
  {
    return $this->CI->db->insert(
      $this->_log_table,
      array(
        "user_id" => $this->CI->session->userdata("user_id"),
        "time" => $time,
        "level" => $level,
        "text" => $text
      )
    );
  }

  public function add_message($level, $text, $time = NULL, $save = FALSE)
  {
    if ($time === NULL)
      $time = time();
    $this->_messages[] = array(
      "level" => $level,
      "text" => $text,
      "time" => $time
    );
    if ($save == TRUE)
      return $this->_save_message($level, $text, $time);
    return TRUE;
  }

  public function load_messsages($limit = NULL, $offset = NULL)
  {
    $this->CI->db->from($this->_log_table);
    $this->CI->db->select(array("time", "level", "text"));
    $this->CI->db->where("user_id", $this->CI->session->userdata("user_id"));
    if ($limit !== NULL)
      $this->CI->db->limit($limit);
    if ($offset !== NULL)
      $this->CI->db->offset($offset);
    $query = $this->CI->db->get();
    foreach ($query->result() as $row)
      $this->add_message($row->level, $row->text, $row->time);
  }

  public function count_messages()
  {
    $this->CI->db->from($this->_log_table);
    $this->CI->db->where("user_id", $this->CI->session->userdata("user_id"));
    return $this->CI->db->count_all_results();
  }

  public function get_output($with_time = TRUE)
  {
    $output = "";
    foreach ($this->_messages as $message)
    {
      $output .= alert(
        $message["level"],
        $message["text"],
        $with_time === TRUE ? $message["time"] : NULL,
        TRUE
      );
    }
    return $output;
  }
}