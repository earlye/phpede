<?php

function exception_to_array( $e , $include_trace = false , $include_previous = false )
{
  if ( !isset($e))
    return null;

  $result = array( "message" => $e->getMessage(),
            "code" => $e->getCode(),
            "file" => $e->getFile(),
            "line" => $e->getLine());

  if ( $include_trace )
    $result["trace"] = $e->getTrace();

  if ( $include_previous )
    $result["previous"] = exception_to_array($e->getPrevious(),$include_trace,$include_previous);

  return $result;
}

?>