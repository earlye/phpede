<?php

function parse_argv( $usage )
{
  $usage = json_decode_throw( $usage );
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
  array_shift($argv);
  while(count($argv))
    {
      $cmd = array_shift($argv);
      $entry = entry($alias_map, $cmd, null);
      if (isset($entry))
        $entry->value = array_shift($argv);
    }

  foreach( $usage as $entry )
    {
      if ($entry->required && !isset( $entry->value ))
        {
          $message = "Usage: ".basename(__FILE__)." ";
          $descriptions = "";
          foreach( $usage as $entry )
            {
              if (!$entry->required)
                $message .= "[";
              $message .= join($entry->aliases,"|")." {".$entry->name."}";
              if (!$entry->required)
                $message .= "]";
              else
                $message .= " ";

              $descriptions .= " {".$entry->name."} ".$entry->description."\n";
            }
          die("$message\n$descriptions");
        }
    }
  return $usage_map;
}

?>