<?php
	include 'header.php';
	include 'config/database.php';

	if(isset($_POST['submit_enquiry'])){
		$stmt = $conn->prepare("INSERT INTO enquiries(name, contact, interested_course, message) VALUES(?, ?, ?, ?)");
		$stmt->bind_param("ssss", $_POST['name'], $_POST['contact'], $_POST['course'], $_POST['message']);

		if($stmt->execute()){
			$success = "Registration submitted! We will contact you soon.";
		}
	}
?>
	<div style="background: #2c3e50; padding: 20px; color: white; text-align: center;">
		<h1>IT Training Group</h1>
		<p>Student Registration / Enquiry</p>
	</div>
	<div class="auth-container" style="margin-top: 50px;">
		<h2>Register Interest</h2>
		<?php if(isset($success)) echo "<p style='color:green; text-align:center; margin-bottom:10px;'>$success</p>"; ?>
		<form method="POST" autocomplete="off">
			<input type="text" name="name" placeholder="Full Name" required>
			<input type="text" name="contact" placeholder="Phone / Email" required>
			<select name="course" required>
				<option value="">Select Interested Course</option>
				<?php
					$c_res = $conn->query("SELECT course_name FROM courses");
					while($c = $c_res->fetch_assoc()) echo "<option value='{$c['course_name']}'>{$c['course_name']}</option>";
				?>
			</select>
			<textarea name="message" placeholder="Additional questions?"></textarea>
			<button type="submit" name="submit_enquiry">Submit</button>
		</form>
		<p style="text-align:center; margin-top:15px;"><a href="login.php" style="color: #666; text-decoration: none; font-size: 12px;">Admin Portal</a></p>
	</div>
<?php include 'footer.php'; ?>