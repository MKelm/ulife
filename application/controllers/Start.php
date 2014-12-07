<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Start extends CI_Controller {

  public function index()
  {
    $this->view->title = "Start";
    $this->view->page = "start";
    $this->view->load();
  }
}