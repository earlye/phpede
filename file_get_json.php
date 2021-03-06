<?php

function file_get_json( $filename )
{
  if ( !file_exists( $filename ) )
    throw new exception( "file_get_json failed: \"$filename\" does not exist." );
  $contents = file_get_contents( $filename );
  return json_decode_throw( $contents );
}

?>