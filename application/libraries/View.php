<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View {

  private $CI;

  public $layout = "default";

  public $title = "";

  public $page = "";

  public $data = array();

  public $valid_user = FALSE;

  public $has_form = FALSE;

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->CI->load->helper("output");
    $this->valid_user = $this->CI->session->userdata("valid_user") === TRUE;
  }

  function load($return = FALSE)
  {
    if ($this->has_form === TRUE)
      $this->CI->load->helper("form");

    $data = $this->data;
    $data["page"] = $this->page;
    $data["title"] = $this->title;
    $data["valid_user"] = $this->valid_user;

    $layoutData = array();
    $layoutData["page"] = $this->page;
    $layoutData["valid_user"] = $this->valid_user;
    $layoutData["title"] = $this->title;
    $layoutData["content"] = $this->CI->load->view(
      "content/".$this->page, $data, TRUE
    );

    if ($return)
    {
      $output = $this->CI->load->view("layouts/".$this->layout, $layoutData, TRUE);
      return $output;
    }
    else
    {
      $this->CI->load->view("layouts/".$this->layout, $layoutData, FALSE);
    }
  }
}