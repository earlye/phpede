<?php

function http_body()
{
  return file_get_contents("php://input");
}


?>