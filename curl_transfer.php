<?php

require_once "entry.php";
require_once "http_result_strings.php";

function curl_transfer( $url , $curloptions )
{
  global $config;

  $verbose = isset( $config->curl ) && $config->curl->verbose;

  $fiveMBs = 5 * 1024 * 1024;
  $header_file = fopen("php://temp/maxmemory:$fiveMBs", 'w');
  if ( !isset($curloptions[CURLOPT_WRITEHEADER]) )
    {
      $curloptions[CURLOPT_WRITEHEADER] = $header_file;
      $curloptions[CURLINFO_HEADER_OUT] = true;
      $curloptions[CURLOPT_HEADER] = true;
    }

  if ( $verbose )
    {
      $method = entry( $curloptions, CURLOPT_CUSTOMREQUEST, "GET" );
      $data = entry( $curloptions, CURLOPT_POSTFIELDS , "" );
      $parsed_url = parse_url( $url );
      $path = $parsed_url['path'];
      $query = @$parsed_url['query'];
      $uri = $path;
      if ( strlen( $query ) )
        $uri .= "?$query";
      echo "===\nRequest: $url\n";
      echo "$method $uri HTTP/1.1\nHeaders:\n";
      foreach( entry( $curloptions, CURLOPT_HTTPHEADER , array() ) as $header )
        echo "$header\n";
      echo "Data:\n$data\n";

      echo "===\n";
    }

  $curl = curl_init( $url );
  foreach( $curloptions as $id => $value )
    {
      curl_setopt( $curl , $id , $value );
    }

  $result = curl_exec( $curl );

  $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
  $headers = substr($result, 0, $header_size);
  $result  = substr($result, $header_size);

  $http_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);

  if ( $verbose )
    {
      echo "Response: $http_code\n";
      echo "$headers";
      echo "$result\n";
      echo "===\n";
    }

  if ( ! ( 200 <= $http_code && $http_code < 300 ) )
    {
      throw new curl_exception( "HTTP code: $http_code" , $http_code , $headers , $result , null );
    }

  return $result;
}

?>