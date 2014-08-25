<?php

function http_get_request_header( $name , $default = null )
{
  $headers = getallheaders();
  if ( !isset($headers[$name] ) )
    return $default;
  return $headers[$name];
}

?>