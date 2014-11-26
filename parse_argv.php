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

  $need_help = false;
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
  $args = $argv;
  $command = array_shift($args);
  while(count($args))
    {
      $cmd = array_shift($args);
      $entry = entry($alias_map, $cmd, null);
      if (isset($entry))
        {
          if( @$entry->multi )
            {
              if ( !isset($entry->value) )
                $entry->value = array();
              array_push( $entry->value, array_shift( $args ));
            }
          else if ( @$entry->type == "flag" )
            {
              $entry->value = true;
            }
          else
            $entry->value = array_shift($args);
        }
      else if ($cmd == "--help" )
        {
          $need_help = true;
        }
    }

  foreach( $usage as $entry )
    {
      if (@$entry->required && !isset( $entry->value ))
        {
          $need_help = true;
          break;
        }
    }

  if ( $need_help )
    die( parse_argv_help( $options ) );

  return $usage_map;
}

?>