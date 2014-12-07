<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

  /**
  * Generic callback used to call callback methods for form validation.
  *
  * @param string
  *        - the value to be validated
  * @param string
  *        - a comma separated string that contains the model name, method name
  *          and any optional values to send to the method as a single parameter.
  *          First value is the name of the model.
  *          Second value is the name of the method.
  *          Any additional values are values to be send in an array to the method.
  *
  *      EXAMPLE RULE:
  *  external_callbacks[some_model,some_method,some_string,another_string]
  */
  public function external_callbacks( $postdata, $param )
  {
    $param_values = explode( ',', $param );

    // Make sure the model is loaded
    $model = $param_values[0];
    $this->CI->load->model( $model );
    if (strpos($model, "/") !== FALSE)
    {
      $model = explode("/", $model)[1];
    }

    // Rename the second element in the array for easy usage
    $method = $param_values[1];

    // Check to see if there are any additional values to send as an array
    if( count( $param_values ) > 2 )
    {
      // Remove the first two elements in the param_values array
      array_shift( $param_values );
      array_shift( $param_values );

      $argument = $param_values;
    }

    // Do the actual validation in the external callback
    if( isset( $argument ) )
    {
      $callback_result = $this->CI->$model->$method( $postdata, $argument );
    }
    else
    {
      $callback_result = $this->CI->$model->$method( $postdata );
    }

    return $callback_result;
  }

  // --------------------------------------------------------------

}