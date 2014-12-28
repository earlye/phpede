<?php

function schema_style_field( $field )
{
  $result = new StdClass();
  $result->name = $field->Field;
  if ( starts_with( $field->Type , "bigint" ) )
    $result->type = "bigint";
  else if ( $field->Type == "text" )
    $result->type = "text";
  else
    $result->type = strtolower($field->Type);

  if ( $field->Key == "PRI" )
    $result->key = "PRIMARY";
  if ( $field->Key == "UNI" )
    $result->key = "UNIQUE";

  return $result;
}

?>