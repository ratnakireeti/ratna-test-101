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
?>  
</body>
</html>