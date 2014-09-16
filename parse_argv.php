<?php

function parse_argv( $options )
{
  $usage = json_decode_throw( $options );

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
          else if ( @$entry->type == "flag" )
            {
              $entry->value = true;
            }
          else
            $entry->value = array_shift($argv);
        }
    }

  foreach( $usage as $entry )
    {
      if (@$entry->required && !isset( $entry->value ))
        {
          die( parse_argv_help( $options ) );
        }
    }
  return $usage_map;
}

?>