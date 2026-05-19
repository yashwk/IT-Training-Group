<?php
include 'config/database.php';

if(isset($_POST['signup'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admins(name,email,contact,password)
            VALUES('$name','$email','$contact','$password')";

    if($conn->query($sql)){
        echo "Signup Successful";
    }else{
        echo "Error";
    }
}
?>

<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="contact" placeholder="Contact" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="signup">Signup</button>
</form>