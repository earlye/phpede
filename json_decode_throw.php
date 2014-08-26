<?php

function json_decode_throw( $string )
{
  $object = json_decode( $string );
  if (isset($object))
    return $object;
  switch( json_last_error() )
    {
    case JSON_ERROR_NONE:
      return null; // the serialized object in $string was actually 'null'.
    default:
      throw new Exception( json_last_error_msg() , json_last_error() );
    }
}

?>