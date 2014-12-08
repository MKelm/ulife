<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('page_nav_item_active'))
{
  function page_nav_item_active($activePage, $page)
  {
    if (strpos($activePage, "/") === FALSE && strpos($page, "/") !== FALSE)
      $page = explode("/", $page)[0];
    echo ($activePage == $page) ? " class=\"active\" " : "";
  }
}

if ( ! function_exists('sub_nav_item_active'))
{
  function sub_nav_item_active($activePageAction, $pageAction)
  {
    echo ($pageAction == $activePageAction) ? "active" : "";
  }
}

if ( ! function_exists('form_field_error_status'))
{
  function form_field_error_status($fieldErrors, $fieldName)
  {
    echo array_key_exists($fieldName, $fieldErrors) ?
      " has-error has-feedback" : "";
  }
}

if ( ! function_exists('form_field_error_glyph'))
{
  function form_field_error_glyph($fieldErrors, $fieldName)
  {
    echo array_key_exists($fieldName, $fieldErrors) ?
      "<span class=\"glyphicon glyphicon-remove form-control-feedback\"></span>"
      : "";
  }
}

if ( ! function_exists('get_numeric_value'))
{
  function get_numeric_value($value)
  {
    if ($value < 1000)
    {
      $value = sprintf("%.1f", $value);
    }
    else if ($value < 1000000)
    {
      $value = sprintf("%.1fK", $value/1000);
    }
    else
    {
      $value = sprintf("%.1fM", $value/1000000);
    }
    if (strpos($value, ".0") !== FALSE)
      echo str_replace(".0", "", $value);
    else
      echo $value;
  }
}

if ( ! function_exists('get_numeric_time_value'))
{
  function get_numeric_time_value($value)
  {
    if ($value < 60)
    {
      $value = $value."s";
    }
    else if ($value < 3600)
    {
      $value = sprintf("%.1fm", $value/60);
    }
    else if ($value < 86400)
    {
      $value = sprintf("%.1fh", $value/3600);
    }
    else
    {
      $value = sprintf("%.1fd", $value/86400);
    }
    if (strpos($value, ".0") !== FALSE)
      echo str_replace(".0", "", $value);
    else
      echo $value;
  }
}