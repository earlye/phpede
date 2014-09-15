<?php

function AssertNotNull( $actual )
{
  if (!isset($actual))
    throw new TestFailureException( "Expected not null, got \"$actual\"" );
}

?>