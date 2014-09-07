<?php

function AssertFalse( $expected , $message = "Expected true, got false" )
{
  if ( $expected )
    throw new TestFailureException( $message );
}

?>