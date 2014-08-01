<?php

function posix_sysname()
{
  $posix_uname = posix_uname();
  return $posix_uname['sysname'];
}

?>