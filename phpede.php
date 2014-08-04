<?php

// Grab all files in the same directory as this module and require them, too.
// In Emacs, try M-x, find-file-at-point on this string: "."
foreach (glob(pathinfo( __FILE__ ,  PATHINFO_DIRNAME )."/*.php") as $filename)
  {
    require_once $filename;
  }

?>