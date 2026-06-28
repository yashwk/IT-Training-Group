<?php
	include 'header.php';
	if(!isset($_SESSION['admin_id'])){
		header("Location: login.php");
		exit();
	}
	include 'config/database.php';
	include 'navbar.php';
	include 'sidebar.php';

	if(isset($_POST['add_payment'])){
		$stmt = $conn->prepare("INSERT INTO fees_payments(trainee_id, amount_paid, payment_method) VALUES(?, ?, ?)");
		$stmt->bind_param("ids", $_POST['trainee_id'], $_POST['amount_paid'], $_POST['payment_method']);
		$stmt->execute();
		header("Location: payments.php");
		exit();
	}

	if(isset($_GET['delete'])){
		$stmt = $conn->prepare("DELETE FROM fees_payments WHERE id=?");
		$stmt->bind_param("i", $_GET['delete']);
		$stmt->execute();
		header("Location: payments.php");
		exit();
	}
?>
	<div class="main">
		<div class="card">
			<h2>Record Payment</h2>
			<form method="POST" autocomplete="off">
				<div class="form-row">
					<select name="trainee_id" required>
						<option value="">Select Trainee</option>
						<?php
							$t_res = $conn->query("SELECT id, name, contact FROM trainees");
							while($t = $t_res->fetch_assoc()) echo "<option value='{$t['id']}'>{$t['name']} ({$t['contact']})</option>";
						?>
					</select>
					<input type="number" step="0.01" name="amount_paid" placeholder="Amount Paid" required>
					<select name="payment_method" required>
						<option value="">Payment Method</option>
						<option value="Cash">Cash</option>
						<option value="UPI">UPI</option>
						<option value="Bank Transfer">Bank Transfer</option>
						<option value="Card">Card</option>
					</select>
				</div>
				<button type="submit" name="add_payment">Save Payment</button>
			</form>
		</div>

		<div class="card">
			<h2>Recent Payments</h2>
			<table>
				<tr>
					<th>Date</th>
					<th>Trainee</th>
					<th>Amount</th>
					<th>Method</th>
					<th>Action</th>
				</tr>
				<?php
					$query = "SELECT p.id, p.amount_paid, p.payment_date, p.payment_method, t.name 
                          FROM fees_payments p 
                          JOIN trainees t ON p.trainee_id = t.id 
                          ORDER BY p.payment_date DESC";
					$result = $conn->query($query);
					while($row = $result->fetch_assoc()){
						?>
						<tr>
							<td><?php echo htmlspecialchars($row['payment_date']); ?></td>
							<td><?php echo htmlspecialchars($row['name']); ?></td>
							<td><?php echo htmlspecialchars($row['amount_paid']); ?></td>
							<td><?php echo htmlspecialchars($row['payment_method']); ?></td>
							<td><a href="payments.php?delete=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete?');">Delete</a></td>
						</tr>
					<?php } ?>
			</table>
		</div>
	</div>
<?php include 'footer.php'; ?>