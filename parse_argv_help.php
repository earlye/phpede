<?php

function parse_argv_help( $options )
{
  global $argv;

  $usage = json_decode_throw( $options );
  $command = $argv[0];

  $overview = "";

  if ( !is_array($usage) )
    {
      $overview = @$usage->overview;
      $usage = $usage->parameters;
    }


  $message = "";
  if (!empty_string($overview))
    {
      $message .= "Overview:\n  $overview\n\n";
    }

  $message .= "Usage:\n  ".basename($command)." ";
  $descriptions = "";
  foreach( $usage as $entry )
    {
      $parameter = "";
      if (!$entry->required)
        $parameter .= "[";
      $parameter .= join($entry->aliases,"|");
      if (@$entry->type != "flag")
        $parameter .= " {".$entry->name."}";

      if (!@$entry->required)
        $parameter .= "] ";
      else
        $parameter .= " ";

      $message .= $parameter;

      $descriptions .= "\n* $parameter : ".@$entry->description."\n";
      if (!empty_string(@$entry->type))
        $descriptions .= "  Type: {$entry->type}\n";
      if (@$entry->multi)
        $descriptions .= "  This parameter can be repeated multiple times.\n";

    }

  return "$message\n\nOptions:$descriptions";
}

?>