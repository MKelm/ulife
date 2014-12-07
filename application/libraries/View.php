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

  private function _is_secured_page()
  {
    $secured_pages = array("start", "research", "buildings", "units");
    foreach ($secured_pages as $secured_page)
    {
      if (strpos($this->page, $secured_page) !== FALSE)
        return TRUE;
    }
    return FALSE;
  }

  public function load($return = FALSE)
  {
    if ($this->has_form === TRUE) // helper for forms
      $this->CI->load->helper("form");

    $layoutData = array();
    if ($this->valid_user === TRUE) // user data for general output
    {
      $this->CI->load->model("account/account_model");
      $layoutData["user"] = $this->CI->account_model->get_user_data(
        $this->CI->session->userdata("user_id")
      );
    }
    else if ($this->_is_secured_page() === TRUE)
    {
      // disable view on protected pages without login
      redirect("account/login");
    }

    $layoutData["page"] = $this->page;
    $layoutData["valid_user"] = $this->valid_user;
    $layoutData["title"] = $this->title;

    $data = $this->data;
    $data["page"] = $this->page;
    $data["title"] = $this->title;
    $data["valid_user"] = $this->valid_user;
    if (isset($layoutData["user"]))
      $data["user"] = $layoutData["user"];

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