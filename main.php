<html>
<head>
<scipt>
	function fullName(firstName, lastName, callback){
	  console.log("My name is " + firstName + " " + lastName);
	  callback(lastName);
	}

	var greeting = function(ln){
	  console.log('Welcome Mr. ' + ln);
	};

	fullName("Jackie", "Chan", greeting);
</script>
</head>
<body>
<?php
    echo 'Hello Ratna Kireeti Eluri! Welcome to ratna-test-101 PHP app with script. ';
    echo 'This is another test.'
?>    
</body>
</html>