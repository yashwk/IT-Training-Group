<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}
?>

<h1>Welcome <?php echo $_SESSION['admin']; ?></h1>

<ul>
    <li><a href="trainees.php">Manage Trainees</a></li>
    <li><a href="admins.php">Manage Admins</a></li>
</ul>