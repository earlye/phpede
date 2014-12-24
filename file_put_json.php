<?php

function file_put_json($filename,$data,$options=0) {
  file_put_contents($filename,up_json_encode($data,$options));
}

?>