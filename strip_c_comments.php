<?php

// This could probably be optimized by changing each state to search for the next character, and copying whole swaths of the string at once rather than a character at a time.
// Another possibility would be to create a list of comments to remove, and then remove them from the back to the front.
// But honestly, we haven't profiled it to prove it's a performance issue, so I'm not going to worry about it yet.
function strip_c_comments( $string )
{
  $result = "";
  $state_init = 0;
  $state_saw_slash = 1;
  $state_cpp_comment = 2;
  $state_c_comment = 3;
  $state_c_comment_star = 4;
  $state_dstring = 5;
  $state_dstring_escape = 6;
  $state_sstring = 7;
  $state_sstring_escape = 8;
  $state = $state_init;
  for( $i = 0; $i != strlen( $string ) ; ++$i )
    {
      $ch = $string[ $i ];
      switch( $state )
        {
          case $state_init:
            if ( $ch == '/' )
              {
                $state = $state_saw_slash;
                continue;
              }
            if ( $ch == "\"" )
              {
                $state = $state_dstring;
                $result .= $ch;
                continue;
              }
            if ( $ch == "'" )
              {
                $state = $state_dstring;
                $result .= $ch;
                continue;
              }
            $result .= $ch;
            break;
          case $state_saw_slash:
            if ( $ch == '/' )
              {
                $state = $state_cpp_comment;
                continue;
              }
            if ( $ch == '*' )
              {
                $state = $state_c_comment;
                continue;
              }
            $result .= '/';
            $result .= $ch;
            $state = $state_init;
            break;
          case $state_cpp_comment:
            if ( $ch == "\n" )
              {
                $state = $state_init;
                $result .= "\n";
                continue;
              }
            break;
          case $state_c_comment:
            if ( $ch == '*' )
              {
                $state = $state_c_comment_star;
              }
            break;
          case $state_c_comment_star:
            if ( $ch == '/' )
              {
                $state = $state_init;
                continue;
              }
            if ( $ch != '*' )
              {
                $state = $state_c_comment;
              }
            break;
          case $state_dstring:
            if ( $ch == "\"" )
              {
                $state = $state_init;
                $result .= $ch;
                continue;
              }
            if ( $ch == "\\" )
              {
                $state = $state_dstring_escape;
                $result .= $ch;
                continue;
              }
            $result .= $ch;
            break;
          case $state_dstring_escape:
            $state = $state_dstring;
            $result .= $ch;
            break;
          case $state_sstring:
            if ( $ch == "'" )
              {
                $state = $state_init;
                $result .= $ch;
                continue;
              }
            if ( $ch == "\\" )
              {
                $state = $state_sstring_escape;
                $result .= $ch;
                continue;
              }
            $result .= $ch;
            break;
          case $state_sstring_escape:
            $state = $state_sstring;
            $result .= $ch;
            break;
        }
    }

  return $result;
}

?>