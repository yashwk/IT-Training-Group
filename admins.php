<?php
	include 'config/database.php';

	// ADD ADMIN
	if(isset($_POST['save_admin'])){

		$name = $_POST['name'];
		$email = $_POST['email'];
		$contact = $_POST['contact'];

		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

		$photo = $_FILES['photo']['name'];
		$temp = $_FILES['photo']['tmp_name'];

		move_uploaded_file($temp, "uploads/".$photo);

		$sql = "INSERT INTO admins(name,email,contact,password,photo)
            VALUES('$name','$email','$contact','$password','$photo')";

		$conn->query($sql);
	}

	// DELETE ADMIN
	if(isset($_GET['delete'])){

		$id = $_GET['delete'];

		$conn->query("DELETE FROM admins WHERE id=$id");
	}
?>

<h2>Add Admin</h2>

<form method="POST" enctype="multipart/form-data">

	<input type="text" name="name" placeholder="Name">
	<input type="email" name="email" placeholder="Email">
	<input type="text" name="contact" placeholder="Contact">
	<input type="password" name="password" placeholder="Password">

	<input type="file" name="photo">

	<button type="submit" name="save_admin">Save Admin</button>
</form>

<hr>

<h2>Admin List</h2>

<table border="1" cellpadding="10">

	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Email</th>
		<th>Photo</th>
		<th>Action</th>
	</tr>

	<?php
		$result = $conn->query("SELECT * FROM admins");

		while($row = $result->fetch_assoc()){
			?>

			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['email']; ?></td>

				<td>
					<img src="uploads/<?php echo $row['photo']; ?>" width="60">
				</td>

				<td>
					<a href="admins.php?delete=<?php echo $row['id']; ?>">
						Delete
					</a>
				</td>
			</tr>

		<?php } ?>

</table>