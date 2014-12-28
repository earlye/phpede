<?php

function http_body_json()
{
  return json_decode_throw(http_body());
}

?>