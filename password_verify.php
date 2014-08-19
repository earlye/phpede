<?php

if ( !function_exists('password_verify') )
  {
    function password_verify( $password , $hash )
    {
      $context = new StdClass();
      $hash_regex = '#\$(.*)\$([0-9][0-9])\$(.*)#';

      $context->hash_regex = $hash_regex;

      preg_match( $context->hash_regex , $hash , $context->matches );
      $context->salt_hash = $context->matches[3];

      $context->rehash = password_hash($password,PASSWORD_BCRYPT,array("salt"=>$context->salt_hash,"cost"=>$context->matches[2],"algo_id"=>$context->matches[1]) );
      $context->verified = $context->rehash == $hash;

      return $context->verified;
    }
  }


?>