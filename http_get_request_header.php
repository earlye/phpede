<?php

if (!function_exists('getallheaders'))
  {
    function getallheaders()
    {
      $headers = '';
      foreach ($_SERVER as $name => $value)
        {
          // header( "x-server-$name: $value" );
          if (substr($name, 0, 5) == 'HTTP_')
            {
              $headers[str_replace(' ', '-', (strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
      //foreach ($headers as $name => $value )
      //  {
      //    header( "x-header-$name: $value" );
      //  }
      return $headers;
    }
  }

function http_get_request_header( $name , $default = null )
{
  $headers = getallheaders();
  if ( !isset($headers[$name] ) )
    return $default;
  return $headers[$name];
}

?>