<?php

if (!function_exists('getallheaders'))
  {
    function getallheaders()
    {
      $headers = array();
      foreach ($_SERVER as $name => $value)
        {
          // header( "x-server-$name: $value" );
          if (substr($name, 0, 5) == 'HTTP_')
            {
              $headers[str_replace(' ', '-', (str_replace('_', ' ', substr($name, 5))))] = $value;
            }
        }
      //foreach ($headers as $name => $value )
      //  {
      //    header( "x-header-$name: $value" );
      //  }
      return $headers;
    }
  }

function get_lowercase_headers()
{
  $temp = getallheaders();
  $result = array();
  foreach( $temp as $key => $value )
    {
      $result[strtolower($key)] = $value;
    }
  return $result;
}

function http_get_request_header( $name , $default = null )
{
  $headers = get_lowercase_headers();
  if ( !isset($headers[$name] ) )
    return $default;
  return $headers[$name];
}

?>