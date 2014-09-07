<?php

function AssertEquals( $expected , $actual , $message = "Expected values to be equal:" )
{
  if ( $expected != $actual )
    throw new TestFailureException( "$message \"$expected\"; \"$actual\"" );
}

?>