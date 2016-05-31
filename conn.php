<?php
  $host        = "host=ec2-23-21-235-126.compute-1.amazonaws.com";
  $port        = "port=5432";
  $dbname      = "dbname=da7tanlbmhlnus";
  $credentials = "user=bdigvfiemjpgai password=nE-iPctpETXTavB1GD83jyOIC-";

  $db = pg_connect( "$host $port $dbname $credentials"  );
  if(!$db){
    echo "Error : Unable to open database\n";
  } else {
    echo "Opened database successfully\n";
  }
?>