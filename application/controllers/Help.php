<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->view->layout = "help";
    $this->view->title = "Hilfe - ";
  }

  public function index()
  {
    $this->concept();
  }

  public function concept() {
    $this->view->title .= "Konzept";
    $this->view->page = "help/concept";
    $this->view->load();
  }

  public function research() {
    $this->view->title .= "Forschung";
    $this->view->page = "help/research";
    $this->view->load();
  }

  public function buildings() {
    $this->view->title .= "Gebäude";
    $this->view->page = "help/buildings";
    $this->view->load();
  }

  public function units() {
    $this->view->title .= "Einheiten";
    $this->view->page = "help/units";
    $this->view->load();
  }
}