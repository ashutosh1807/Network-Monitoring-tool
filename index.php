<?php 
	$db = mysqli_connect('localhost', 'root', '', 'packets');
	if (!$db) {
		die("Connection failed: " . mysqli_connect_error());
	}
	function disp_ipudp($result){
		echo "<table id='customers'>  
						<th>Time Stamp</th>
						<th>Source Mac</th>
						<th>Destination Mac</th>
						<th>Length</th>
						<th>Source ip</th>
						<th>Source port</th>
						<th>Destination ip</th>
						<th>Destination port</th>
						";
			while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
				echo "  <tr>
							<td>" . $row['Time_stamp'] . "</td>
							<td>" . $row['Source_mac'] . "</td>
							<td>" . $row['Destination_mac'] . "</td>
							<td>" . $row['length'] . "</td>
							<td>" . $row['Source_ip'] . "</td>
							<td>" . $row['Source_port'] . "</td>
							<td>" . $row['Destination_ip'] . "</td>
							<td>" . $row['Destination_port'] . "</td>
						</tr>";  //$row['index'] the index here is a field name
			}

			echo "</table>"; //Close the table in HTML

	}
	function disp_arp($result){
		echo "<table id='customers'>  
						<th>Time Stamp</th>
						<th>Source Mac</th>
						<th>Destination Mac</th>
						<th>Length</th>
						<th>Source ip</th>
						<th>Destination ip</th>
						";
			while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
				echo "  <tr>
							<td>" . $row['Time_stamp'] . "</td>
							<td>" . $row['Source_mac'] . "</td>
							<td>" . $row['Destination_mac'] . "</td>
							<td>" . $row['Length'] . "</td>
							<td>" . $row['Source_ip'] . "</td>
							<td>" . $row['Destination_ip'] . "</td>
						</tr>";  //$row['index'] the index here is a field name
			}

			echo "</table>"; //Close the table in HTML

	}
	function packet_type() {
		global $db;
		$answer = $_POST['select'];  
		if ($answer == "ans1") {          
			$query = "SELECT * FROM arp"; //You don't need a ; like you do in SQL
			$result = mysqli_query($db,$query);
			disp_arp($result);  
		}
		else if ($answer=="ans2") {
			$query = "SELECT * FROM udp"; //You don't need a ; like you do in SQL
			$result = mysqli_query($db,$query);
			disp_ipudp($result);
		}    
		else if ($answer=="ans3"){
			$query = "SELECT * FROM ipv4"; //You don't need a ; like you do in SQL
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
		<a href="top5.php">Top Users</a>
			
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