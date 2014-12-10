<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define("LOG_LEVEL_SUCCESS", 0);
define("LOG_LEVEL_INFO", 1);
define("LOG_LEVEL_WARNING", 2);
define("LOG_LEVEL_DANGER", 3);

class Users_log {

  private $CI;

  private $_log_table = "users_log";

  private $_log_level_classes = array(
    "success", "info", "warning", "danger"
  );

  private $_log_level_glyphs = array(
    "glyphicon glyphicon-ok-sign",
    "glyphicon glyphicon-info-sign",
    "glyphicon glyphicon-warning-sign",
    "glyphicon glyphicon-exclamation-sign"
  );

  private $_messages = array();

  public function __construct()
  {
    $this->CI =& get_instance();
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

  public function set_message($level, $text, $time = NULL, $save = FALSE)
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
      $this->set_message($row->level, $row->text, $row->time);
  }

  public function count_messages()
  {
    $this->CI->db->from($this->_log_table);
    $this->CI->db->where("user_id", $this->CI->session->userdata("user_id"));
    return $this->CI->db->count_all_results();
  }

  public function get_output()
  {
    $output = "";
    foreach ($this->_messages as $message)
    {
      $output .= sprintf(
        '<div class="alert alert-%s" role="alert">'.
        '<span class="%s" aria-hidden="true"></span>'.
        ' %s <strong>%s</strong></div>',
        $this->_log_level_classes[$message["level"]],
        $this->_log_level_glyphs[$message["level"]],
        date("d.m.Y H:i:s", $message["time"]), $message["text"]
      );
    }
    return $output;
  }
}