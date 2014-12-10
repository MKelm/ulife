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

  public function log($page = 1)
  {
    $this->load->library("users_log");
    $this->users_log->load_messsages(5, ($page - 1) * 5);
    $data["users_log_output"] = $this->users_log->get_output();

    $this->load->library("pagination");
    $config["base_url"] = base_url()."start/log/";
    $config["total_rows"] = $this->users_log->count_messages();
    $config["per_page"] = 5;
    $this->pagination->initialize($config);
    $data["users_log_pagination"] = $this->pagination->create_links();

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