<?php
// Start the session
session_start();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="Stylesheet.css">
<title> Trip Detail </title>
</head>

<style>
			h1 {
					text-align: center;
					font-family: Times New Roman;
					font-variant: small-caps;
					font-size: 50px;
					padding-bottom: 10px;
			}   
			.bod{
					width: 70%;
					margin: 0 auto;
			}
			table{
					width:70%;
					margin: 0 auto;
			}

			tr{
					padding: 10px 10px;
			}
			input{
					font-family: Times New Roman;
					font-variant: none;
			}
			button {
					width: 70%;
					text-align: center;
					margin: 0 auto;
					font-size: 25px;
					font-family: Times New Roman;
					font-variant: small-caps;
					justify-content: center;
			}
			.lbutton {
					background-color: #E9E9E9;
					color: #00508F;
					border: 2px solid black;
					padding: 20px 20px;
					border-radius: 10px;
			}
			.lbutton:hover{
					background-color: white;
			}
	</style>

<body>
	<header><a class="header" href="dashboard.php">International Travel Expense Tracker</a></header>

	<nav>
			<ul>
					<div class="leftnav">
							<li><a href = "aboutdash.html">About</a></li>
							<li><a href = "dashboard.php" class="currpage">Dashboard</a></li>
							<div class="rightnav">

									<!-- END SESSION IF CLICKED --> 
									<li><a href = "logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a> </li>

							</div>
					</div>
			</ul>
	</nav>

	<div class="bod">

	<h1> Trip Detail </h1>
	

	
	<?php
		
		/*
		This page connects to the MySQL server and display all previous
		expense entries of a user.
		
		William Huang
		*/
		
		
		
		//for server page
		$servername = "localhost";
		$username = "id14882043_ltaque01";
		$password = "WilliamLeonKateriJulia4!";
		$dbname = "id14882043_itet";

		//From Dashboard
		$tripName = $_POST["tripid"];
		$loginID = $_SESSION["userID"];
		$homeCurrency = $_SESSION["HomeCurrency"];
		echo "$tripName <br>  $loginID <br> $currency <br>";
		
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		else {
			 echo "connection successful!<br>";
		}

		$sql = "SELECT tripname, categories.name, expense_date, expense_name,
						cost_local, local_currency,
						default_currency,	cost_home, 
						tripID, local_currency, CategoryID
						FROM trips INNER JOIN expenses INNER JOIN categories 
											 INNER JOIN users
						ON tripID = trips.ID AND CategoryID = categories.ID
						AND userID = users.ID";
						//WHERE userID = " .$loginID. " AND tripname =" .$tripName; 
		$result = $conn->query($sql);
		
		
		
		$tripId = "";
		$homeCurrency = "";
		$localCurrency = "";
		/*SELECT tripname, categories.name, expense_date, expense_name,
						cost_local, local_currency,
						default_currency,	cost_home 	 
						FROM trips INNER JOIN expenses INNER JOIN categories 
											 INNER JOIN users
						ON tripID = trips.ID AND CategoryID = categories.ID
						AND userID = users.ID
						WHERE userID = 1 AND tripname = "Sweet Home Alabama"
		*/

		
		//output data of each row in a table
		//header
		echo "
			<table><tr>
								<th> Trip </th>
								<th> Category </th>
								<th> Date </th>
								<th> Name </th>
								<th> Local Currency </th>
								<th> Local Cost </th>
								<th> Home Currency </th>
								<th> Home Cost </th>
						 </tr>
		";
		echo mysqli_num_rows($result);
		if (mysqli_num_rows($result) > 0) {
			
		  while($row = $result->fetch_assoc()) {
		    echo "<tr> <td>" . $row["tripname"]
					 . "</td><td>" . $row["categories.name"]
					 . "</td><td>" . $row["expense_date"]
					 . "</td><td>" . $row["expense_name"]
					 . "</td><td>" . $row["cost_local"]
					 . "</td><td>" . $row["local_currency"]
					 . "</td><td>" . $row["default_currency"]
					 . "</td><td>" . $row["cost_home"] . "</td></tr>";
					 
				$tripID = $row["tripID"];
				$localCurrency = $row["local_currency"];
		  }
			
			echo "</table>" . $homeCurrency . $localCurrency;
			
		} else {
		  echo "</table> 0 results";
		}
		$conn->close();

	?>
	<br><br><br><br>
	<button type="button" id="addexpensebutton" onclick="">Add Expense</button>
	<footer>ITET</footer>
	
</body>
</html>