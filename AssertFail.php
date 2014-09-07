<?php

function AssertFail( $message = "Expected true, got false" )
{
  throw new TestFailureException( $message );
}

?>