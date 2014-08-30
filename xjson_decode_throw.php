<?php

function xjson_decode_throw( $string )
{
  $string = strip_c_comments( $string );
  $object = json_decode( $string );
  if (isset($object))
    return $object;
  switch( json_last_error() )
    {
    case JSON_ERROR_NONE:
      return null; // the serialized object in $string was actually 'null'.
    default:
      $lines = explode( "\n" , $string );
      foreach( $lines as $line )
        error_log( "json line:$line" );
      throw new Exception( json_last_error_msg() , json_last_error() );
    }
}

?>