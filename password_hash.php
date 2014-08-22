<?php

if ( !function_exists('password_hash') )
  {
    define( 'PASSWORD_DEFAULT' , 1 );
    define( 'PASSWORD_BCRYPT' , 1 );

    function password_hash( $password , $algo , $options = null )
    {
      if (!isset($options))
        $options = array();
      if (!isset($options["salt"]))
        $options["salt"] = random_string( "./0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" , CRYPT_SALT_LENGTH );
      if (!isset($options["cost"]))
        $options["cost"] = 10;

      switch( $algo )
        {
          case PASSWORD_BCRYPT:
          default: // unrecognized - use bcrypt.
            $cost = intval($options["cost"]);
            if ( !( 4 <= $cost && $cost <= 31 ) )
              $cost = 10;

            $algo_id = '2y';
            if (isset($options["algo_id"]))
              $algo_id = $options["algo_id"];

            $salt = '$'.$algo_id.'$'.$cost.'$'.$options["salt"];
        }

      return crypt( $password , $salt );
    }
  }

?>