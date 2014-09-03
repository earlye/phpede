<?php

class cleaner
{
  function __construct($closure,$params,$references = null)
  {
    $this->closure = $closure;
    $this->params = $params;
    $this->references = $references;
  }

  function __destruct()
  {
    call_user_func_array($this->closure,$this->params);
  }
};

?>