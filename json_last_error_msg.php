<?php

if (!function_exists('json_last_error_msg'))
  {
    function json_last_error_msg()
    {
      $number = json_last_error();
      switch( $number )
        {
          case JSON_ERROR_NONE: return ' - No errors';
          case JSON_ERROR_DEPTH: return ' - Maximum stack depth exceeded';
          case JSON_ERROR_STATE_MISMATCH: return ' - Underflow or the modes mismatch';
          case JSON_ERROR_CTRL_CHAR: return ' - Unexpected control character found';
          case JSON_ERROR_SYNTAX: return ' - Syntax error, malformed JSON';
          case JSON_ERROR_UTF8: return ' - Malformed UTF-8 characters, possibly incorrectly encoded';
          default: return ' - Unknown error';
        }
    }
  }

?>