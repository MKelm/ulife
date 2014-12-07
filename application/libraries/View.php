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
    if ($this->has_form === TRUE) // helper for forms
      $this->CI->load->helper("form");

    $layoutData = array();
    if ($this->valid_user === TRUE) // user data for general output
    {
      $this->CI->load->model("account/user_model");
      $layoutData["user"] = $this->CI->user_model->get_data(
        $this->CI->session->userdata("user_id")
      );
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