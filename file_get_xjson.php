<?php

function file_get_xjson( $filename )
{
  $contents = file_get_contents( $filename );
  return xjson_decode_throw( $contents );
}

?>