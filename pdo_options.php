<?php namespace phpede;

function pdo_options( $options_object )
{
  if ( !isset($options_object) )
    {
      header( "x-pdo_options: no options object" );
      return null;
    }

  $temp = get_object_vars($options_object);
  $result = array();
  foreach( $temp as $key => $value )
    {
      $result[constant($key)] = $value;
    }
  return $result;
}

?>