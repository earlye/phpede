<?php

function http_body_json()
{
  return json_decode_throw(file_get_contents("php://input"));
}

?>