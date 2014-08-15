<?php namespace phpede;

function collapse( $array , $field , $field_value )
{
  $result = $array[0];
  foreach( $array as $entry )
    {
      if ( !isset( $entry->$field ) )
        continue;
      if ( $entry->$field != $field_value )
        continue;

      foreach( get_object_vars($entry) as $key => $value )
        $result->$key = $value;
    }
  return $result;
}

?>