<?php

function get_request( $name , $default_value = null )
{
  if (!isset($_REQUEST[$name]))
    return $default_value;
  return $_REQUEST[$name];
}

?>