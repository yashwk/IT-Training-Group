<?php
    include 'header.php';
    if(!isset($_SESSION['admin_id'])){
        header("Location: login.php");
        exit();
    }
    include 'config/database.php';
    include 'navbar.php';
    include 'sidebar.php';

    $trainee_count = $conn->query("SELECT COUNT(*) as c FROM trainees")->fetch_assoc()['c'];
    $course_count = $conn->query("SELECT COUNT(*) as c FROM courses")->fetch_assoc()['c'];
    $center_count = $conn->query("SELECT COUNT(*) as c FROM centers")->fetch_assoc()['c'];
    $enquiry_count = $conn->query("SELECT COUNT(*) as c FROM enquiries")->fetch_assoc()['c'];
?>
    <div class="main">
        <div class="card">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h2>
        </div>
        <div class="dashboard-boxes">
            <div class="dashboard-card">
                <h3>Total Trainees</h3>
                <h1><?php echo $trainee_count; ?></h1>
            </div>
            <div class="dashboard-card">
                <h3>Active Courses</h3>
                <h1><?php echo $course_count; ?></h1>
            </div>
            <div class="dashboard-card">
                <h3>Centers</h3>
                <h1><?php echo $center_count; ?></h1>
            </div>
            <div class="dashboard-card">
                <h3>Enquiries</h3>
                <h1><?php echo $enquiry_count; ?></h1>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>