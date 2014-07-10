<?php

foreach (glob("lib/phpede/*.php") as $filename)
  {
    require_once $filename;
  }

?>