<!DOCTYPE html>
<html>
<head>
<script>
	function fullName(firstName, lastName, callback){
	  console.log("My name is " + firstName + " " + lastName);
	  callback(lastName);
	}

	var greeting = function(ln){
	  console.log('Welcome Mr. ' + ln);
	};

	var notGreeting = function(ln){
	  console.log('This is not a Welcome Mr. ' + ln);
	};

	fullName("Jackie", "Chan", greeting);
	fullName("Ratna Kireeti", "Eluri", notGreeting);
	fullName("Mahendra Singh", "Dhoni", function(ln){console.log('Welcome Mr. ' + ln);});
</script>
</head>
<body>
<?php
    echo 'Hello Ratna Kireeti Eluri! Welcome to ratna-test-101 PHP app with script. ';
    echo 'This is another test.'
?>  
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

   $sql =<<<EOF
      CREATE TABLE COMPANY
      (ID INT PRIMARY KEY     NOT NULL,
      NAME           TEXT    NOT NULL,
      AGE            INT     NOT NULL,
      ADDRESS        CHAR(50),
      SALARY         REAL);
EOF;

   $ret = pg_query($db, $sql);
   if(!$ret){
      echo pg_last_error($db);
   } else {
      echo "Table created successfully\n";
   }

   $sql1 =<<<EOF
      INSERT INTO COMPANY (ID,NAME,AGE,ADDRESS,SALARY)
      VALUES (1, 'Paul', 32, 'California', 20000.00 );

      INSERT INTO COMPANY (ID,NAME,AGE,ADDRESS,SALARY)
      VALUES (2, 'Allen', 25, 'Texas', 15000.00 );

      INSERT INTO COMPANY (ID,NAME,AGE,ADDRESS,SALARY)
      VALUES (3, 'Teddy', 23, 'Norway', 20000.00 );

      INSERT INTO COMPANY (ID,NAME,AGE,ADDRESS,SALARY)
      VALUES (4, 'Mark', 25, 'Rich-Mond ', 65000.00 );
EOF;

   $ret1 = pg_query($db, $sql1);
   if(!$ret1){
      echo pg_last_error($db);
   } else {
      echo "Records created successfully\n";
   }

$sql2 =<<<EOF
      SELECT * from COMPANY;
EOF;

   $ret2 = pg_query($db, $sql2);
   if(!$ret2){
      echo pg_last_error($db);
      exit;
   } 
   while($row = pg_fetch_row($ret2)){
      echo "ID = ". $row[0] . "\n";
      echo "NAME = ". $row[1] ."\n";
      echo "ADDRESS = ". $row[2] ."\n";
      echo "SALARY =  ".$row[4] ."\n\n";
   }
   echo "Operation done successfully\n";

   pg_close($db);
?>  
</body>
</html>