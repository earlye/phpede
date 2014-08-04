<?php

// scan $first_directory and its parent directories until you find a
// file with the specified basename, and return the path to that file.
// return null if not found.
function find_file_in_parent_directories( $basename , $first_directory )
{
  $dir = $first_directory;
  if ( !isset( $dir ) )
    $dir = pathinfo(__FILE__,PATHINFO_DIRNAME);

  while(true)
    {
      $filename = $dir.DIRECTORY_SEPARATOR.$basename;
      if ( file_exists( $filename ) )
        {
          return $filename;
        }
      $parent_dir = pathinfo($dir,PATHINFO_DIRNAME);
      if( $parent_dir == $dir )
        {
          return null;
        }
      $dir = $parent_dir;
    }
}


?>
