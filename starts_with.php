<?php

function starts_with($haystack, $needle)
{
  return $needle === "" || strpos($haystack, $needle) === 0;
}

?>