<?php

function find_ring( $ring ) {

  $ring_options = array
    ( $ring ,
      $ring.".json",
      getenv("HOME").DIRECTORY_SEPARATOR.".passwords".DIRECTORY_SEPARATOR.$ring,
      getenv("HOME").DIRECTORY_SEPARATOR.".passwords".DIRECTORY_SEPARATOR.$ring.".json" );

  $ring_failures = array();

  foreach( $ring_options as $entry ) {
    if ( file_exists( $entry ) ) {
      $ring = $entry;
      break;
    } else {
      array_push( $ring_failures , $entry );
    }
  }

  if (!file_exists($ring))
    {
      throw new exception( "Could not find $ring. Tried:".implode($ring_failures," ".PATH_SEPARATOR." ")."\n" );
    }

  return file_get_json($ring);
}

?>