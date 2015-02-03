<?php

if ( ! defined( "PATH_SEPARATOR" ) )
  {
    if ( strpos( $_ENV[ "OS" ], "Win" ) !== false )
      define( "PATH_SEPARATOR", ";" );
    else define( "PATH_SEPARATOR", ":" );
  }

function update_include_path( )
{
  $this_file = __FILE__;
  $this_dir = pathinfo($this_file,PATHINFO_DIRNAME);
  $parent_dir = pathinfo($this_dir,PATHINFO_DIRNAME);
  set_include_path(get_include_path(). PATH_SEPARATOR ."$parent_dir");
}

// Grab all files in the same directory as this module and require them, too.
// In Emacs, try M-x, find-file-at-point on this string: "."
foreach (glob(pathinfo( __FILE__ ,  PATHINFO_DIRNAME ). DIRECTORY_SEPARATOR . "*.php") as $filename)
  {
    require_once $filename;
  }


function determineTimezoneFromSystem($default)
{
  // On many systems (Mac, for instance) "/etc/localtime" is a symlink
  // to the file with the timezone info
  if (is_link("/etc/localtime"))
    {
      // If it is, that file's name is actually the "Olsen" format timezone
      $filename = readlink("/etc/localtime");

      $pos = strpos($filename, "zoneinfo");
      if ($pos)
        {
          // When it is, it's in the "/usr/share/zoneinfo/" folder
          return substr($filename, $pos + strlen("zoneinfo/"));
        }
      else
        {
          // If not, bail
          return $default;
        }
    }
  else if (file_exists('/etc/timezone'))
    {
      // On other systems, like Ubuntu, there's file with the Olsen time
      // right inside it.
      $timezone = file_get_contents("/etc/timezone");
      if (!strlen($timezone))
        {
          return $default;
        }
      return $timezone;
    }
  else
    {
      return  $default;
    }
}

date_default_timezone_set(determineTimezoneFromSystem('America/Chicago'));
update_include_path();

?>