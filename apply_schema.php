<?php

function apply_schema($schema,$tablePrefix,$connection)
{
  echo "Checking schema\n";
  $query = "show tables like '".$tablePrefix."%'";
  $tables = $connection->query($query)->fetchAll(PDO::FETCH_COLUMN);

  foreach( $schema as $schemaTable )
    {
      $full_name = $tablePrefix.$schemaTable->name;
      echo "checking table $full_name\n";
      if ( in_array( $full_name , $tables ) )
        {
          echo "- $full_name already exists. checking column list.\n";
          $query = "DESCRIBE `$full_name`";
          $tableLayout = $connection->query($query)->fetchAll(PDO::FETCH_OBJ);

          $changing_columns = array();
          foreach( $schemaTable->columns as $column )
            {
              $field = phpede\select($tableLayout,"Field",$column->name);
              if (null==$field)
                {
                  array_push($changing_columns,$column);
                }
              else
                {
                  $schema_field = schema_style_field( $field );
                  unset($column->comments);
                  if ( $schema_field != $column )
                    {
                      echo "mysql field:";print_r($field);
                      echo "schema_field:";print_r($schema_field);
                      echo "column:";print_r($column);
                      $column->changing=true;
                      array_push($changing_columns,$column);
                    }
                }
            }

          if ( count($changing_columns) )
            {
              $query = "ALTER TABLE `$full_name`";;
              $separator = "";
              foreach( $changing_columns as $column )
                {
                  echo "changing column:";print_r($column);
                  $name = $column->name;
                  $type = $column->type;
                  $change_mode = $column->changing ? "MODIFY" : "ADD";
                  switch( trim($column->key) )
                    {
                      case "PRIMARY" : $keyspec = "PRIMARY KEY"; break;
                      case "UNIQUE" : $keyspec = "UNIQUE KEY"; break;
                      default: $keyspec = "";
                    }
                  $query .= "$separator $change_mode COLUMN `$name` $type $keyspec";
                  $separator = ",";
                }
              echo "$query\n";
              $connection->exec($query);

            }
          else
            {
              echo "- columns are okay.\n";
            }
          continue;
        }
      else
        {
          $query = "CREATE TABLE $full_name (";
          $separator = "";
          foreach( $schemaTable->columns as $column)
            {
              $query .= $separator.$column->name." ".$column->type;
              switch( trim($column->key))
                {
                  case "PRIMARY" : $query .= " PRIMARY KEY"; break;
                  case "UNIQUE" : $query .= " UNIQUE KEY"; break;
                }

              $separator = ",";
            }
          $query .= ")";
          echo "- $query\n";
          $connection->exec($query);
        }
    }
}

?>