<?php
    include 'header.php';
    if(!isset($_SESSION['admin_id'])){
        header("Location: login.php");
        exit();
    }
    include 'config/database.php';
    include 'navbar.php';
    include 'sidebar.php';

    if(isset($_POST['save_center'])){
        $center_name = $_POST['center_name'];
        $stmt = $conn->prepare("INSERT INTO centers(center_name) VALUES(?)");
        $stmt->bind_param("s", $center_name);
        $stmt->execute();
        header("Location: centers.php");
        exit();
    }

    if(isset($_GET['delete'])){
        $id = intval($_GET['delete']);
        $stmt = $conn->prepare("DELETE FROM centers WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: centers.php");
        exit();
    }
?>
    <div class="main">
        <div class="card">
            <h2>Add Center</h2>
            <form method="POST" autocomplete="off">
                <input type="text" name="center_name" placeholder="Center Name" required>
                <button type="submit" name="save_center">Save Center</button>
            </form>
        </div>
        <div class="card">
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
                            <td><?php echo htmlspecialchars($row['center_name']); ?></td>
                            <td>
                                <a href="centers.php?delete=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
            </table>
        </div>
    </div>
<?php include 'footer.php'; ?>