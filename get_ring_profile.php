<?php

function get_ring_profile( $ring , $profile ) {
  if (isset($profile)) {
    if ( !isset($ring->$profile)) {
      throw new exception( "ring does not have profile $profile.");
    }
    $ring = $ring->$profile;
  }
  return $ring;
}

?>