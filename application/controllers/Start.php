<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Start extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->view->layout = "start";
    $this->view->title = "Start - ";
  }

  public function index()
  {
    $this->overview();
  }

  public function overview()
  {
    $this->view->title .= "Übersicht";
    $this->view->page = "start/overview";
    $this->view->load();
  }

  public function log()
  {
    $this->view->title .= "Protokoll";
    $this->view->page = "start/log";
    $this->view->load();
  }

  public function map()
  {
    $this->load->library("map");
    $data["table"] = $this->map->get_table();
    $this->view->data = $data;
    $this->view->title .= "Karten";
    $this->view->page = "start/map";
    $this->view->load();
  }
}