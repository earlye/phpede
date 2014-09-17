<?php

function preg_match_throw( $pattern , $subject, &$matches = null, $flags = 0 , $offset = 0 )
{
  $result = preg_match( $pattern, $subject, $matches, $flags, $offset);
  if ( FALSE === $result )
    throw new exception( 'preg_match encountered an error' );
  return $result;
}

?>