<?php namespace phpede;

function pdo_mysql_connection_id($connection)
{
  return $connection->query('SELECT CONNECTION_ID()')->fetchColumn();
}

?>