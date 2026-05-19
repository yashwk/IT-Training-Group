<?php
	include 'header.php';

	if(!isset($_SESSION['admin_id'])){
		header("Location: login.php");
		exit();
	}

	include 'config/database.php';
	include 'navbar.php';
	include 'sidebar.php';

	if(isset($_GET['delete'])){
		$stmt = $conn->prepare("DELETE FROM enquiries WHERE id=?");
		$stmt->bind_param("i", $_GET['delete']);
		$stmt->execute();
		header("Location: enquiries.php");
		exit();
	}
?>
	<div class="main">
		<div class="card">
			<h2>Manage Enquiries</h2>
			<table>
				<tr>
					<th>Date</th>
					<th>Name</th>
					<th>Contact</th>
					<th>Course</th>
					<th>Message</th>
					<th>Action</th>
				</tr>
				<?php
					$result = $conn->query("SELECT * FROM enquiries ORDER BY created_at DESC");
					while($row = $result->fetch_assoc()){
						?>
						<tr>
							<td><?php echo htmlspecialchars(date('M d, Y', strtotime($row['created_at']))); ?></td>
							<td><?php echo htmlspecialchars($row['name']); ?></td>
							<td><?php echo htmlspecialchars($row['contact']); ?></td>
							<td><?php echo htmlspecialchars($row['interested_course']); ?></td>
							<td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
							<td>
								<a href="enquiries.php?delete=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete this enquiry?');">Delete</a>
							</td>
						</tr>
					<?php } ?>
			</table>
		</div>
	</div>
<?php include 'footer.php'; ?>