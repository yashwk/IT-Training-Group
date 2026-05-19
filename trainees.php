<?php
    include 'config/database.php';
    $conn->query("INSERT INTO enquiries(name,contact,interested_course,message)
                  VALUES('$name','$contact','$course','$message')");

?>

<h2>Add Trainee</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="father_name" placeholder="Father Name" required>
    <input type="text" name="contact" placeholder="Contact" required>

    <input type="text" name="course" placeholder="Course">
    <input type="text" name="course_type" placeholder="Course Type">
    <input type="text" name="duration" placeholder="Duration">
    <input type="text" name="center_name" placeholder="Center">

    <input type="number" name="total_fee" placeholder="Total Fee">
    <input type="number" name="paid_fee" placeholder="Paid Fee">

    <input type="file" name="photo">

    <button type="submit" name="save_trainee">Save</button>
</form>

<hr>

<h2>Trainee List</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Course</th>
        <th>Total Fee</th>
        <th>Remaining Fee</th>
        <th>Photo</th>
        <th>Action</th>
    </tr>

    <?php
        $result = $conn->query("SELECT * FROM trainees");

        while ($row = $result->fetch_assoc()){
    ?>

    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['course']; ?></td>
        <td><?php echo $row['total_fee']; ?></td>
        <td><?php echo $row['remaining_fee']; ?></td>

        <td>
            <img src="uploads/<?php echo $row['photo']; ?>" width="60">
        </td>

        <td>
            <a href="trainees.php?delete=<?php echo $row['id']; ?>">
                Delete
            </a>
        </td>
    </tr>

    <?php } ?>

</table>

<hr>

<h2>Manage Enquiry</h2>

<form method="POST">

    <input type="text" name="enquiry_name" placeholder="Name">
    <input type="text" name="enquiry_contact" placeholder="Contact">
    <input type="text" name="interested_course" placeholder="Interested Course">

    <textarea name="message" placeholder="Message"></textarea>

    <button type="submit" name="save_enquiry">Save Enquiry</button>
</form>