<div class="navbar">
    <h1>IT Training Group</h1>
    <div style="display: flex; align-items: center; gap: 20px;">
        <span>Hello, <?php echo isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin'; ?></span>
        <a href="logout.php" style="background: #e74c3c; padding: 8px 15px; border-radius: 5px; color: white; text-decoration: none;">Logout</a>
    </div>
</div>