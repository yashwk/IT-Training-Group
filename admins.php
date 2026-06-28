<?php
    include 'header.php';
    if(!isset($_SESSION['admin_id'])){
        header("Location: login.php");
        exit();
    }
    include 'config/database.php';
    include 'navbar.php';
    include 'sidebar.php';

    if(isset($_POST['save_admin'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $photo = "";
        if(!empty($_FILES['photo']['name'])){
            if(!is_dir('uploads')) mkdir('uploads');
            $photo = time() . '_' . $_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$photo);
        }

        $stmt = $conn->prepare("INSERT INTO admins(name, email, contact, password, photo) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $contact, $password, $photo);
        $stmt->execute();
        header("Location: admins.php");
        exit();
    }

    if(isset($_GET['delete'])){
        $id = intval($_GET['delete']);
        $stmt = $conn->prepare("DELETE FROM admins WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: admins.php");
        exit();
    }
?>
    <div class="main">
        <div class="card">
            <h2>Add Admin</h2>
            <form method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="form-row">
                    <input type="text" name="name" placeholder="Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-row">
                    <input type="text" name="contact" placeholder="Contact" required>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <input type="file" name="photo" accept="image/*">
                <button type="submit" name="save_admin">Save Admin</button>
            </form>
        </div>
        <div class="card">
            <h2>Admin List</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                <?php
                    $result = $conn->query("SELECT * FROM admins");
                    while($row = $result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td>
                                <?php if($row['photo']) { ?>
                                    <img src="uploads/<?php echo $row['photo']; ?>" width="50" height="50" style="object-fit:cover;">
                                <?php } ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <?php if($row['id'] != $_SESSION['admin_id']) { ?>
                                    <a href="admins.php?delete=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete?');">Delete</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
            </table>
        </div>
    </div>
<?php include 'footer.php'; ?>