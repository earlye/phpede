<?php

function empty_string($string)
{
  if (!isset($string)) return true;
  if ($string==='') return true;
  return false;
}

?>