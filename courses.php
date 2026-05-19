<?php

	session_start();

	if(!isset($_SESSION['admin'])){
		header("Location: login.php");
		exit();
	}

	include 'db.php';


	// CREATE TABLE

	$createTable = "
CREATE TABLE IF NOT EXISTS courses(

    id INT PRIMARY KEY AUTO_INCREMENT,

    course_name VARCHAR(100) NOT NULL,

    course_type VARCHAR(100) NOT NULL,

    duration VARCHAR(100) NOT NULL
)
";

	$conn->query($createTable);


	// ADD COURSE

	if(isset($_POST['add_course'])){

		$course_name = trim($_POST['course_name']);
		$course_type = trim($_POST['course_type']);
		$duration = trim($_POST['duration']);

		if(
			!empty($course_name) &&
			!empty($course_type) &&
			!empty($duration)
		){

			$stmt = $conn->prepare(
				"INSERT INTO courses
            (course_name, course_type, duration)
            VALUES (?, ?, ?)"
			);

			$stmt->bind_param(
				"sss",
				$course_name,
				$course_type,
				$duration
			);

			$stmt->execute();
		}
	}


	// DELETE COURSE

	if(isset($_GET['delete'])){

		$id = intval($_GET['delete']);

		$stmt = $conn->prepare(
			"DELETE FROM courses WHERE id=?"
		);

		$stmt->bind_param("i", $id);

		$stmt->execute();
	}


	// FETCH COURSES

	$result = $conn->query(
		"SELECT * FROM courses ORDER BY id DESC"
	);

?>

<!DOCTYPE html>

<html>

<head>

	<title>Courses</title>

	<link rel="stylesheet" href="style.css">

</head>

<body>

<?php include 'navbar.php'; ?>
<?php include 'sidebar.php'; ?>


<div class="main">

	<div class="card">

		<h2>Add Course</h2>

		<form method="POST">

			<input
				type="text"
				name="course_name"
				placeholder="Course Name"
				required
			>

			<input
				type="text"
				name="course_type"
				placeholder="Course Type"
				required
			>

			<input
				type="text"
				name="duration"
				placeholder="Duration"
				required
			>

			<button type="submit" name="add_course">
				Add Course
			</button>

		</form>

	</div>


	<div class="card">

		<h2>Course List</h2>

		<table>

			<tr>

				<th>ID</th>
				<th>Course Name</th>
				<th>Course Type</th>
				<th>Duration</th>
				<th>Action</th>

			</tr>

			<?php while($row = $result->fetch_assoc()) { ?>

				<tr>

					<td>
						<?php echo $row['id']; ?>
					</td>

					<td>
						<?php echo $row['course_name']; ?>
					</td>

					<td>
						<?php echo $row['course_type']; ?>
					</td>

					<td>
						<?php echo $row['duration']; ?>
					</td>

					<td>

						<a
							href="courses.php?delete=<?php echo $row['id']; ?>"
							class="action-btn delete-btn"
							onclick="return confirm('Delete this course?')"
						>
							Delete
						</a>

					</td>

				</tr>

			<?php } ?>

		</table>

	</div>

</div>

</body>

</html>