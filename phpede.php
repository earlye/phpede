<?php

function update_include_path( )
{
  $this_file = __FILE__;
  $this_dir = pathinfo($this_file,PATHINFO_DIRNAME);
  $parent_dir = pathinfo($this_dir,PATHINFO_DIRNAME);
  set_include_path(get_include_path().":$parent_dir");
}

// Grab all files in the same directory as this module and require them, too.
// In Emacs, try M-x, find-file-at-point on this string: "."
foreach (glob(pathinfo( __FILE__ ,  PATHINFO_DIRNAME )."/*.php") as $filename)
  {
    require_once $filename;
  }

date_default_timezone_set('America/Chicago');
update_include_path();

?>