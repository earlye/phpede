<?php

function pdo_query($connection,$query)
{
  $result = $connection->query($query);
  if (!isset($result) || ($result===FALSE))
    {
      $error = new StdClass();
      $error->errorCode = $connection->errorCode();
      $error->errorInfo = $connection->errorInfo();
      throw new Exception( json_encode($error));
    }
  return $result;
}

?>