<?php

function AssertNull( $actual )
{
  if (isset($actual))
    throw new TestFailureException( "Expected null, got \"$actual\"" );
}

?>