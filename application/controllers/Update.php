<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
  }

  public function perform($key = NULL)
  {
    if (!empty($key))
    {
      $data = array("round_amount" => 0);
      $this->load->model("update_model");
      $config = $this->update_model->load_config();

      if (isset($config["update_time"]) &&
          $config["update_time"] < time() - $config["update_interval"])
      {
        // update round number
        if ($config["update_time"] > 0)
        {
          $data["round_amount"] = floor(
            (time() - $config["update_time"]) / $config["update_interval"]
          );
        }
        $config["round_number"] += $data["round_amount"];
        $this->update_model->set_config("round_number", $config["round_number"]);

        // update research
        $this->update_model->update_research();

        // update config
        $this->update_model->set_config(
          "users_amount", $this->update_model->get_users_amount()
        );
        $this->update_model->set_config("update_time", time());
        $this->update_model->save_config();

      }

      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($data));
    }
    else
      show_404();
  }

}