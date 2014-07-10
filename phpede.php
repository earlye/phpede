<?php

foreach (glob("lib/phpede/*.php") as $filename)
  {
    echo "$filename\n";
    require_once $filename;
  }

?>