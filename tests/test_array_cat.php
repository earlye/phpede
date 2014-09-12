<?php

function test_array_cat()
{
  $foo = array_cat( array( "a" ) , array( "b" ) );
  if ( $foo != array("a","b"))
    throw new TestFailureException( "Expected foo to be ['a','b']" );
}

?>