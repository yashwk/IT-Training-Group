<?php
    include 'header.php';
    include 'config/database.php';

    if(isset($_POST['signup'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO admins(name, email, contact, password) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $contact, $password);

        if($stmt->execute()){
            header("Location: login.php");
            exit();
        } else {
            $error = "Error creating account. Email might exist.";
        }
    }
?>
    <div class="auth-container">
        <h2>Admin Signup</h2>
        <?php if(isset($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
        <form method="POST" autocomplete="off">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="contact" placeholder="Contact" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="signup">Signup</button>
        </form>
        <p style="text-align:center; margin-top:15px;"><a href="login.php">Back to Login</a></p>
    </div>
<?php include 'footer.php'; ?>