<?php

function file_get_json( $filename )
{
  $contents = file_get_contents( $filename );
  return json_decode_throw( $contents );
}

?>