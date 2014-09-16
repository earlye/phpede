<?php

function stdclass_replace_recursive( $dest , $src )
{
  $properties = get_object_vars( $src );
  foreach( $properties as $key => $value )
    {
      if (isset($dest->$key) && is_object($dest->$key))
        {
          stdclass_replace_recursive($dest->$key,$value);
        }
      else if ( isset($dest->$key) && is_array($dest->$key) && is_array($value))
        {
          $new_values = array_diff($value,$dest->$key);
          foreach( $new_values as $new_value )
            array_push($dest->$key,$new_value);
        }
      else
        {
          $dest->$key = $value;
        }
    }
}

?>