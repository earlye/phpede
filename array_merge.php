<?php

function array_cat()
{
  $result = array();
  $args = func_get_args();
  foreach( $args as $arg )
    {
      if ( $arg != null )
        $result = array_merge( $result , $arg );
    }
  return $result;
}

?>