<?php

function AssertEquals( $expected , $actual )
{
  if ( $expected != $actual )
    throw new TestFailureException( "Expected \"$expected\" , got \"$actual\"" );
}

?>