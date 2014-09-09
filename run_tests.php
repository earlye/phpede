<?php

// This function is really designed to be called from a top-level php CLI. You
// can think of it as a main() which is good at being a test harness.

// In the context of this test harness, a test is just a bare function which
// takes a $config object and throws an exception to indicate failure.

function run_tests( )
{
  global $config;

  $usage = <<<JSON
[ { "name" : "config" , "aliases" : [ "-c", "-config" ] , "description" : "test configuration" , "required" : true },
  { "name" : "files" , "aliases" : [ "-f", "-file" ] , "description" : "Test files to run. If not provided, loads all php files starting with 'test_' in the local directory" , "required" : false , "multi" : true },
  { "name" : "tests" , "aliases" : ["-t", "-test" ] , "description" : "Specific test functions to run. If not provided, runs all functions starting with 'test_' in specified files" , "required" : false , "multi" : true } ]
JSON;

  $arguments = parse_argv( $usage );
  $config = file_get_xjson( $arguments['config']->value );
  $test_files = @$arguments['files']->value;
  $test_functions = @$arguments['tests']->value;

  if (!isset($test_files) || !count($test_files))
    {
      $test_files = glob("test_*.php");
    }

  $failed_tests = array();
  $passed_tests = array();
  foreach( $test_files as $test_file )
    {
      try
        {
          require_once $test_file;
        }
      catch( Exception $e )
        {
          $failure = new StdClass();
          $failure->name = "Loading $test_file";
          $failure->error = $e;
          array_push( $failed_tests, $failure );
        }
    }

  if ( !isset($test_functions) || !count($test_functions))
    {
      $functions = get_defined_functions();
      $user_functions = $functions['user'];
      $test_functions = array();
      foreach( $user_functions as $function )
        {
          if ( starts_with( $function, 'test_' ) )
            array_push($test_functions,$function);
        }
    }

  foreach( $test_functions as $function )
    {
      echo "Test: $function ...\n";
      $start = microtime(true);
      try
        {
          $function($config);
          $finish = microtime(true);
          $time = number_format(($finish - $start),6)."s";
          $pass = new StdClass();
          $pass->name = $function;
          $pass->time = $time;
          array_push( $passed_tests , $pass );
          echo "PASS: $function {$time}\n";
        }
      catch( Exception $e )
        {
          $finish = microtime(true);
          $time = number_format(($finish - $start),6)."s";
          $failure = new StdClass();
          $failure->time = $time;
          $failure->name = $function;
          $failure->error = $e;
          array_push( $failed_tests, $failure );
          echo "FAIL: $function {$time} $e\n";
        }
    }

  if (count($passed_tests))
    {
      echo "Passed tests:".count($passed_tests)."\n";
      foreach( $passed_tests as $pass )
        {
          echo " * [{$pass->time}] {$pass->name} \n";
        }
    }

  if (count($failed_tests))
    {
      echo "Failed tests:".count($failed_tests)."\n";
      foreach( $failed_tests as $failure )
        {
          echo " * [{$failure->time}] {$failure->name} \n";
        }
    }
}

?>