<?php

function pdo_execute( $statement )
{
  $result = $statement->execute();
  if ( $result === FALSE )
    {
      $error = new StdClass();
      $error->errorCode = $statement->errorCode();
      $error->errorInfo = $statement->errorInfo();
      throw new Exception( json_encode($error));
    }
  return $result;
}

?>