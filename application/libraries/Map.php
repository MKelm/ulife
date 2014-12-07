<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map {

  private $CI;

  private $_map_width = 10;
  private $_map_height = 10;

  public function __construct()
  {
    $this->CI =& get_instance();
  }

  public function get_table() {
    $this->CI->load->library("table");

    $tmpl = array(
      "table_open" => "<table class=\"table table-bordered\">",
    );
    $this->CI->table->set_template($tmpl);

    $headers = array("");
    for ($i = 1; $i < $this->_map_width + 1; $i++)
      $headers[] = $i;
    $this->CI->table->set_heading($headers);

    $data = array();
    for ($i = 0; $i < $this->_map_height; $i++)
    {
      $row_num = $i + 1;
      $data[$i] = array("<strong>".$row_num."</strong>");
      for ($j = 1; $j < $this->_map_width + 1; $j++)
        $data[$i][$j] = 0;
    }

    return $this->CI->table->generate($data);
  }
}