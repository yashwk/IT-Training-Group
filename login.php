<?php
    include 'header.php';
    include 'config/database.php';

    if(isset($_SESSION['admin_id'])){
        header("Location: dashboard.php");
        exit();
    }

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT id, name, password FROM admins WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['password'])){
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_name'] = $row['name'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid Password";
            }
        } else {
            $error = "Invalid Email";
        }
    }
?>
    <div class="auth-container">
        <h2>Admin Login</h2>
        <?php if(isset($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
        <form method="POST" autocomplete="off">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p style="text-align:center; margin-top:15px;"><a href="signup.php">Register Admin</a></p>
    </div>
<?php include 'footer.php'; ?>