<?php

function content_type( $value )
{
  header( "Content-Type: $value" );
}

?>