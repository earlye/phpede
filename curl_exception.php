<?php

class curl_exception extends Exception
{
  public function __construct($message, $code, $headers, $responseBody, $previous = null )
  {
    parent::__construct( $message , $code , $previous );
    $this->headers = trim($headers);
    $this->responseBody = $responseBody;
  }

  public function getResponseBody()
  {
    return $this->responseBody;
  }

  public function __toString()
  {
    $result = "exception '".get_class($this)."' (".$this->getCode().") with message '".$this->getMessage()."' in ".$this->getFile().":".$this->getLine()."\n";
    $result .= "Response Headers:\n{$this->headers}\n";
    $result .= "Response Body:\n{$this->responseBody}\n";
    $result .= "Stack Trace:\n";
    $result .= $this->getTraceAsString();
    return $result;
  }
};

?>