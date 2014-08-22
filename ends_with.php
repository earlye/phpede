<?php

function ends_with($haystack, $needle)
{
  return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

?>