<?php 
	$db = mysqli_connect('localhost', 'root', '', 'packets');
	if (!$db) {
		die("Connection failed: " . mysqli_connect_error());
	}
	function disp_ipudp($result){
		echo "<table id='customers'>  
						<th>No of entries</th>
						<th>Source ip</th>
						";
			while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
				echo "  <tr>
							<td>" . $row['No_of_entries'] . "</td>
							<td>" . $row['Source_ip'] . "</td>
						</tr>";  //$row['index'] the index here is a field name
			}

			echo "</table>"; //Close the table in HTML

	}
	function disp_arp($result){
		echo "<table id='customers'>  
						<th>No of entries</th>
						<th>Source ip</th>
						";
			while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
				echo "  <tr>
							<td>" . $row['No_of_entries'] . "</td>
							<td>" . $row['Source_ip'] . "</td>
						</tr>";  //$row['index'] the index here is a field name
			}

			echo "</table>"; //Close the table in HTML

	}
	function packet_type() {
		global $db;
		$answer = $_POST['select'];  
		if ($answer == "ans1") {          
			$query = "SELECT * FROM arptop5"; //You don't need a ; like you do in SQL
			$result = mysqli_query($db,$query);
			disp_arp($result);  
		}
		else if ($answer=="ans2") {
			$query = "SELECT * FROM udptop5"; //You don't need a ; like you do in SQL
			$result = mysqli_query($db,$query);
			disp_ipudp($result);
		}    
		else if ($answer=="ans3"){
			$query = "SELECT * FROM ipv4top5"; //You don't need a ; like you do in SQL
			$result = mysqli_query($db,$query);
			disp_ipudp($result);
		}  
	}    

	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Welcome to Network Monitoring Tool</h2>
	</div>
	<div class="topnav">
		<a href="login.php">Logout</a>
		<a href="index.php">Packet Details</a>
	</div> 	
	<div class="content">
		<form class="select" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<div class="input">
				<label>ARP</label>
				<input type="radio" name="select" value="ans1" 
					<?php if (isset($_POST['select']) && $_POST['select']=="ans1") echo "checked";?> >
			</div>
			<div class="input">
				<label>UDP</label>
				<input type="radio" name="select" value="ans2"
					<?php if (isset($_POST['select']) && $_POST['select']=="ans2") echo "checked";?>>
			</div>
			<div class="input">
				<label>IPv4</label>
				<input type="radio" name="select" value="ans3"
					<?php if (isset($_POST['select']) && $_POST['select']=="ans3") echo "checked";?>>
			</div>
			<div class="input">
				<button type="submit" class="btn" name="login_btn">Select</button>
			</div>
		</form>
		<?php packet_type(); ?>
	</div>
</body>
</html>