<?php
    include 'header.php';
    if(!isset($_SESSION['admin_id'])){
        header("Location: login.php");
        exit();
    }
    include 'config/database.php';
    include 'navbar.php';
    include 'sidebar.php';

    if(isset($_POST['add_type'])){
        $stmt = $conn->prepare("INSERT INTO course_types(type_name) VALUES(?)");
        $stmt->bind_param("s", $_POST['type_name']);
        $stmt->execute();
        header("Location: courses.php");
        exit();
    }

    if(isset($_POST['add_duration'])){
        $stmt = $conn->prepare("INSERT INTO durations(duration_label) VALUES(?)");
        $stmt->bind_param("s", $_POST['duration_label']);
        $stmt->execute();
        header("Location: courses.php");
        exit();
    }

    if(isset($_POST['add_course'])){
        $stmt = $conn->prepare("INSERT INTO courses(course_name, course_type_id, duration_id, total_fee) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("siid", $_POST['course_name'], $_POST['course_type_id'], $_POST['duration_id'], $_POST['total_fee']);
        $stmt->execute();
        header("Location: courses.php");
        exit();
    }

    if(isset($_GET['delete'])){
        $stmt = $conn->prepare("DELETE FROM courses WHERE id=?");
        $stmt->bind_param("i", $_GET['delete']);
        $stmt->execute();
        header("Location: courses.php");
        exit();
    }
?>
    <div class="main">
        <div class="dashboard-boxes" style="margin-bottom: 20px;">
            <div class="card" style="flex:1;">
                <h2>Add Course Type</h2>
                <form method="POST">
                    <input type="text" name="type_name" placeholder="Type (e.g. Online)" required>
                    <button type="submit" name="add_type">Save Type</button>
                </form>
            </div>
            <div class="card" style="flex:1;">
                <h2>Add Duration</h2>
                <form method="POST">
                    <input type="text" name="duration_label" placeholder="Duration (e.g. 6 Months)" required>
                    <button type="submit" name="add_duration">Save Duration</button>
                </form>
            </div>
        </div>

        <div class="card">
            <h2>Add Course</h2>
            <form method="POST">
                <div class="form-row">
                    <input type="text" name="course_name" placeholder="Course Name" required>
                    <input type="number" step="0.01" name="total_fee" placeholder="Total Fee" required>
                </div>
                <div class="form-row">
                    <select name="course_type_id" required>
                        <option value="">Select Course Type</option>
                        <?php
                            $t_res = $conn->query("SELECT * FROM course_types");
                            while($t = $t_res->fetch_assoc()) echo "<option value='{$t['id']}'>{$t['type_name']}</option>";
                        ?>
                    </select>
                    <select name="duration_id" required>
                        <option value="">Select Duration</option>
                        <?php
                            $d_res = $conn->query("SELECT * FROM durations");
                            while($d = $d_res->fetch_assoc()) echo "<option value='{$d['id']}'>{$d['duration_label']}</option>";
                        ?>
                    </select>
                </div>
                <button type="submit" name="add_course">Save Course</button>
            </form>
        </div>

        <div class="card">
            <h2>Course List</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Duration</th>
                    <th>Fee</th>
                    <th>Action</th>
                </tr>
                <?php
                    $query = "SELECT c.id, c.course_name, c.total_fee, t.type_name, d.duration_label 
                          FROM courses c 
                          LEFT JOIN course_types t ON c.course_type_id = t.id 
                          LEFT JOIN durations d ON c.duration_id = d.id";
                    $result = $conn->query($query);
                    while($row = $result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['type_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['duration_label']); ?></td>
                            <td><?php echo htmlspecialchars($row['total_fee']); ?></td>
                            <td><a href="courses.php?delete=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete?');">Delete</a></td>
                        </tr>
                    <?php } ?>
            </table>
        </div>
    </div>
<?php include 'footer.php'; ?>