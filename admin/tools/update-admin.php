<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Optional: simple access gate using a token query param
$token = $_GET['token'] ?? $_POST['token'] ?? '';
$allowed = true; // set to ($token === 'your-secret') if you want to protect it further

if (!$allowed) {
	http_response_code(403);
	die('Forbidden');
}

$success = '';
$error = '';

// Load existing admin (by email or first row)
function loadAdmin($email = 'admin@example.com') {
	$result = Database::query("SELECT * FROM admin_users WHERE email = ? LIMIT 1", [$email]);
	if (!empty($result)) return $result[0];
	$result = Database::query("SELECT * FROM admin_users ORDER BY id ASC LIMIT 1");
	return !empty($result) ? $result[0] : null;
}

$admin = loadAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		$email = trim($_POST['email'] ?? '');
		$full_name = trim($_POST['full_name'] ?? '');
		$role = $_POST['role'] ?? 'admin';
		$is_active = isset($_POST['is_active']) ? 1 : 0;
		$new_password = $_POST['new_password'] ?? '';
		$current_email = $_POST['current_email'] ?? ($admin['email'] ?? 'admin@example.com');
		
		if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new Exception('Please provide a valid email');
		}
		
		$params = [$email, $full_name, $role, $is_active, $current_email];
		$sql = "UPDATE admin_users SET email = ?, full_name = ?, role = ?, is_active = ? WHERE email = ?";
		
		Database::beginTransaction();
		Database::execute($sql, $params);
		
		if ($new_password !== '') {
			$hash = password_hash($new_password, PASSWORD_DEFAULT);
			Database::execute("UPDATE admin_users SET password_hash = ? WHERE email = ?", [$hash, $email]);
		}
		
		Database::commit();
		$success = 'Admin user updated successfully';
		$admin = loadAdmin($email);
	} catch (Exception $e) {
		Database::rollback();
		$error = 'Update failed: ' . $e->getMessage();
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Update Admin User | Elpis Admin</title>
	<link rel="stylesheet" href="../../styles.css" />
	<style>
		.container {max-width: 720px; margin: 3rem auto; padding: 2rem;}
		.card {background: var(--color-surface, #fff); border: 1px solid var(--color-border, #eee); border-radius: 12px; padding: 1.5rem;}
		h1 {margin-bottom: 1rem;}
		.form-row {display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;}
		.form-group {display: flex; flex-direction: column; gap: .5rem; margin-bottom: 1rem;}
		.label {font-weight: 600;}
		.input {padding: .75rem 1rem; border: 1px solid var(--color-border, #e5e7eb); border-radius: 8px;}
		.btn {display: inline-flex; align-items: center; justify-content: center; gap: .5rem; padding: .75rem 1.25rem; border-radius: 8px; border: 1px solid transparent; background: #0ea5e9; color: white; font-weight: 600; cursor: pointer;}
		.alert {padding: .75rem 1rem; border-radius: 8px; margin-bottom: 1rem;}
		.alert-success {background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;}
		.alert-error {background: #fff1f2; color: #9f1239; border: 1px solid #fecdd3;}
	</style>
</head>
<body>
	<div class="container">
		<div class="card">
			<h1>Update Admin User</h1>
			<p class="text-sm" style="margin-bottom:1rem; opacity:.8;">Use this utility to update the default admin credentials.</p>
			<?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
			<?php if ($error): ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
			<form method="post">
				<input type="hidden" name="current_email" value="<?php echo htmlspecialchars($admin['email'] ?? 'admin@example.com'); ?>" />
				<div class="form-row">
					<div class="form-group">
						<label class="label">Email</label>
						<input class="input" type="email" name="email" required value="<?php echo htmlspecialchars($admin['email'] ?? 'admin@example.com'); ?>" />
					</div>
					<div class="form-group">
						<label class="label">Full Name</label>
						<input class="input" type="text" name="full_name" value="<?php echo htmlspecialchars($admin['full_name'] ?? ''); ?>" />
					</div>
				</div>
				<div class="form-row">
					<div class="form-group">
						<label class="label">Role</label>
						<select class="input" name="role">
							<option value="admin" <?php echo (($admin['role'] ?? '')==='admin')?'selected':''; ?>>admin</option>
							<option value="super_admin" <?php echo (($admin['role'] ?? '')==='super_admin')?'selected':''; ?>>super_admin</option>
						</select>
					</div>
					<div class="form-group" style="display:flex; align-items:center; gap:.5rem;">
						<input id="is_active" type="checkbox" name="is_active" <?php echo (($admin['is_active'] ?? 1) ? 'checked' : ''); ?> />
						<label for="is_active" class="label" style="margin:0;">Active</label>
					</div>
				</div>
				<div class="form-group">
					<label class="label">New Password (leave blank to keep current)</label>
					<input class="input" type="text" name="new_password" placeholder="Enter new password" />
				</div>
				<div class="form-group">
					<button class="btn" type="submit">Update Admin</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
