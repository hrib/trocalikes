<?php
session_start();

$query = $_POST["query"];
echo $query;
SQLquery($query);

function SQLquery($query){

  $dbopts = parse_url(getenv('DATABASE_URL'));
  $dsn = "pgsql:"
      . "host=" . $dbopts["host"] . ";"
      . "dbname=". ltrim($dbopts["path"],'/') . ";"
      . "user=" . $dbopts["user"] . ";"
      . "port=" . $dbopts["port"] . ";"
      . "sslmode=require;"
      . "password=" . $dbopts["pass"];

  $db = new PDO($dsn);
  $result = $db->query($query);

  
  //$result->fetch(PDO::FETCH_ASSOC);
  echo "<table border='1'>";
  while ($row = $result->fetch(PDO::FETCH_NUM)) {
    echo "<tr>";
    foreach($row as $key => $value){
      echo "<td>" . $value . "</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
  $result->closeCursor();

  
}


function CreateTable(){
  
  $dbopts = parse_url(getenv('DATABASE_URL'));
  $dsn = "pgsql:"
      . "host=" . $dbopts["host"] . ";"
      . "dbname=". ltrim($dbopts["path"],'/') . ";"
      . "user=" . $dbopts["user"] . ";"
      . "port=" . $dbopts["port"] . ";"
      . "sslmode=require;"
      . "password=" . $dbopts["pass"];

  $db = new PDO($dsn);

  $query = "DROP TABLE Users";
  $result = $db->query($query);
  echo var_dump($result);
  echo '<br><br>';
  
  
  
  $query = "CREATE TABLE Users ("
      . "email VARCHAR(30),"
      . "passw VARCHAR(10),"
      . "nome VARCHAR(20),"
      . "sobrenome VARCHAR(20),"
      . "day VARCHAR(2),"
      . "month VARCHAR(2),"
      . "year VARCHAR(4),"
      . "sex VARCHAR(10),"
      . "ultimo_acesso VARCHAR(30),"
      . "status VARCHAR(30)"
      . ");";
  $result = $db->query($query);
  echo var_dump($result);
}

?>
