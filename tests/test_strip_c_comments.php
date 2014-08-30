<?php

function test_string_without_comments()
{
  $input = "{ \"foo\" : \"bar\" }";

  $stripped = strip_c_comments( $input );
  AssertEquals( $input , $stripped );
}

function test_string_with_escape_quote()
{
  $input = <<<TRICKY
"test \\"/*test string inside escaped quotes*/\\""
TRICKY;

  AssertEquals($input,strip_c_comments($input));
}

function test_sstring_with_escape_quote()
{
  $input = <<<TRICKY
'test \\'/*test string inside escaped quotes*/\\''
TRICKY;

  AssertEquals($input,strip_c_comments($input));
}

function test_strip_comments_comment_in_string()
{

  $input = <<<C_CODE
#include "foo.h"
#include <stdio.h>
// Strip this
/* Strip
this */
int main( int argc, char** argv )
{
  printf( "// do not strip this\\n" );
  printf( "/* do not strip\\n" );
  printf( "this */\\n" );
  int a = 32 / 4;
}
C_CODE;

  $expected = <<<C_CODE
#include "foo.h"
#include <stdio.h>


int main( int argc, char** argv )
{
  printf( "// do not strip this\\n" );
  printf( "/* do not strip\\n" );
  printf( "this */\\n" );
  int a = 32 / 4;
}
C_CODE;

  $stripped = strip_c_comments( $input );
  AssertEquals( $expected , $stripped );
}

?>