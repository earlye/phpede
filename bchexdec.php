<?php

// FROM: http://stackoverflow.com/questions/1273484/large-hex-values-with-php-hexdec

function bchexdec($hex)
{
  $dec = 0;
  $len = strlen($hex);
  for ($i = 1; $i <= $len; $i++) {
    $dec = bcadd($dec, bcmul(strval(hexdec($hex[$i - 1])), bcpow('16', strval($len - $i))));
  }
  return $dec;
}

?>