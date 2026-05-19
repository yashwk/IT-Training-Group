<?php
	include 'db.php';

	// ADD CENTER
	if(isset($_POST['save_center'])){

		$center_name = $_POST['center_name'];

		$conn->query("INSERT INTO centers(center_name)
                  VALUES('$center_name')");
	}

	// DELETE CENTER
	if(isset($_GET['delete'])){

		$id = $_GET['delete'];

		$conn->query("DELETE FROM centers WHERE id=$id");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Centers</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main">

	<h2>Add Center</h2>

	<form method="POST">

		<input type="text"
		       name="center_name"
		       placeholder="Center Name"
		       required>

		<button type="submit" name="save_center">
			Save Center
		</button>

	</form>

	<hr>

	<h2>Center List</h2>

	<table>

		<tr>
			<th>ID</th>
			<th>Center Name</th>
			<th>Action</th>
		</tr>

		<?php
			$result = $conn->query("SELECT * FROM centers");

			while($row = $result->fetch_assoc()){
				?>

				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['center_name']; ?></td>

					<td>
						<a class="action-btn delete-btn"
						   href="centers.php?delete=<?php echo $row['id']; ?>">
							Delete
						</a>
					</td>
				</tr>

			<?php } ?>

	</table>

</div>

</body>
</html>