<?php

function file_get_contents_throw( )
{
  $args = func_get_args();
  $result = @call_user_func_array('file_get_contents', $args);
  if ( $result === FALSE )
    {
      throw new Exception('Failed to open ' . json_encode($args));
    }
  return $result;
}

?>