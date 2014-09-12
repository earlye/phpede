<?php

// Extend PDO class to support nested transactions.
class pdo_connection extends PDO
{
  protected $transactionCounter = 0;

  function beginTransaction()
  {
    if(!$this->transactionCounter++)
      return parent::beginTransaction();
    return $this->transactionCounter >= 0;
  }

  function commit()
  {
    if(!--$this->transactionCounter)
      return parent::commit();
    return $this->transactionCounter >= 0;
  }

  function rollback()
  {
    if($this->transactionCounter >= 0)
      {
        $this->transactionCounter = 0;
        return parent::rollback();
      }
    $this->transactionCounter = 0;
    return false;
  }

}

?>