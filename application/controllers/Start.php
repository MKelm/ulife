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
    $this->load->library("users_log");
    $this->users_log->set_message(LOG_LEVEL_SUCCESS, "Das ist super geglückt!");
    $this->users_log->set_message(LOG_LEVEL_INFO, "Toll und super zugleich!");
    $this->users_log->set_message(LOG_LEVEL_WARNING, "Achtung ein Bär kommt!");
    $this->users_log->set_message(LOG_LEVEL_DANGER, "Oh, das geht so nicht!");
    $data["users_log_output"] = $this->users_log->get_output();
    $this->view->data = $data;
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