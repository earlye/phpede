<?php namespace phpede;

function select( $array , $field , $field_value )
{
  foreach( $array as $entry )
    {
      if ( !isset( $entry->$field ) )
        continue;
      if ( $entry->$field != $field_value )
        continue;

      return $entry;
    }
  return null; // not found
}

?>