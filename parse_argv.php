<?php

function parse_argv( $usage )
{
  $usage = json_decode_throw( $usage );

  $overview = "";

  if ( !is_array($usage) )
    {
      $overview = @$usage->overview;
      $usage = $usage->parameters;
    }

  $usage_map = array();
  $alias_map = array();
  foreach( $usage as $entry )
    {
      $usage_map[ $entry->name ] = $entry;
      foreach( $entry->aliases as $alias )
        {
          $alias_map[ $alias ] = $entry;
        }
    }

  global $argv;
  $command = array_shift($argv);
  while(count($argv))
    {
      $cmd = array_shift($argv);
      $entry = entry($alias_map, $cmd, null);
      if (isset($entry))
        {
          if( @$entry->multi )
            {
              if ( !isset($entry->value) )
                $entry->value = array();
              array_push( $entry->value, array_shift( $argv ));
            }
          else
            $entry->value = array_shift($argv);
        }
    }

  foreach( $usage as $entry )
    {
      if (@$entry->required && !isset( $entry->value ))
        {
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
              $parameter .= join($entry->aliases,"|")." {".$entry->name."}";
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
          die("$message\n\nOptions:$descriptions");
        }
    }
  return $usage_map;
}

?>