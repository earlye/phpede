<?php

function random_string( $alphabet , $length )
{
  $result = "";
  $max_index = strlen( $alphabet ) - 1;
  while( $length-- )
    {
      $index = mt_rand( 0 , $max_index );
      $ch = $alphabet[$index];
      $result .= $ch;
    }
  return $result;
}

?>