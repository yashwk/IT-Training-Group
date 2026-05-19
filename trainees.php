<?php
    include 'header.php';
    if(!isset($_SESSION['admin_id'])){
        header("Location: login.php");
        exit();
    }
    include 'config/database.php';
    include 'navbar.php';
    include 'sidebar.php';

    if(isset($_POST['save_trainee'])){
        $photo = "";
        if(!empty($_FILES['photo']['name'])){
            if(!is_dir('uploads')) mkdir('uploads');
            $photo = time() . '_' . $_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$photo);
        }

        $stmt = $conn->prepare("INSERT INTO trainees(name, father_name, contact, course_id, center_id, photo) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiis", $_POST['name'], $_POST['father_name'], $_POST['contact'], $_POST['course_id'], $_POST['center_id'], $photo);
        $stmt->execute();
        header("Location: trainees.php");
        exit();
    }

    if(isset($_GET['delete'])){
        $stmt = $conn->prepare("DELETE FROM trainees WHERE id=?");
        $stmt->bind_param("i", $_GET['delete']);
        $stmt->execute();
        header("Location: trainees.php");
        exit();
    }
?>
    <div class="main">
        <div class="card">
            <h2>Add Trainee</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="text" name="name" placeholder="Name" required>
                    <input type="text" name="father_name" placeholder="Father Name" required>
                    <input type="text" name="contact" placeholder="Contact" required>
                </div>
                <div class="form-row">
                    <select name="course_id" required>
                        <option value="">Select Course</option>
                        <?php
                            $c_res = $conn->query("SELECT * FROM courses");
                            while($c = $c_res->fetch_assoc()) echo "<option value='{$c['id']}'>{$c['course_name']} - {$c['total_fee']}</option>";
                        ?>
                    </select>
                    <select name="center_id" required>
                        <option value="">Select Center</option>
                        <?php
                            $cen_res = $conn->query("SELECT * FROM centers");
                            while($cen = $cen_res->fetch_assoc()) echo "<option value='{$cen['id']}'>{$cen['center_name']}</option>";
                        ?>
                    </select>
                </div>
                <input type="file" name="photo" accept="image/*">
                <button type="submit" name="save_trainee">Save Trainee</button>
            </form>
        </div>

        <div class="card">
            <h2>Trainee List</h2>
            <table>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Center</th>
                    <th>Total Fee</th>
                    <th>Paid Fee</th>
                    <th>Bal</th>
                    <th>Action</th>
                </tr>
                <?php
                    $query = "SELECT t.id, t.name, t.photo, c.course_name, c.total_fee, cen.center_name, 
                          COALESCE((SELECT SUM(amount_paid) FROM fees_payments WHERE trainee_id = t.id), 0) as paid 
                          FROM trainees t 
                          LEFT JOIN courses c ON t.course_id = c.id 
                          LEFT JOIN centers cen ON t.center_id = cen.id";
                    $result = $conn->query($query);
                    while($row = $result->fetch_assoc()){
                        $bal = $row['total_fee'] - $row['paid'];
                        ?>
                        <tr>
                            <td>
                                <?php if($row['photo']) { ?>
                                    <img src="uploads/<?php echo $row['photo']; ?>" width="40" height="40" style="object-fit:cover; border-radius:50%;">
                                <?php } ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['center_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['total_fee']); ?></td>
                            <td><?php echo htmlspecialchars($row['paid']); ?></td>
                            <td><?php echo htmlspecialchars($bal); ?></td>
                            <td><a href="trainees.php?delete=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete?');">Delete</a></td>
                        </tr>
                    <?php } ?>
            </table>
        </div>
    </div>
<?php include 'footer.php'; ?>