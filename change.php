
<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current = $_POST["current_password"];
    $new = $_POST["new_password"];
    $confirm = $_POST["confirm_password"];

    if (strlen($new) < 6) {
        $message = "New password must be at least 6 characters.";
    } elseif ($new !== $confirm) {
        $message = "New passwords do not match.";
    } else {
        $id = $_SESSION["user_id"];

        $stmt = mysqli_prepare($conn, "SELECT password FROM users WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($current, $user["password"])) {
            $hashed = password_hash($new, PASSWORD_DEFAULT);

            $update = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE id = ?");
            mysqli_stmt_bind_param($update, "si", $hashed, $id);

            if (mysqli_stmt_execute($update)) {
                $message = "Password changed successfully!";
            } else {
                $message = "Something went wrong. Please try again.";
            }
        } else {
            $message = "Current password is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f0ff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            width: 320px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px #0001;
        }
        h2 { text-align: center; color: #5b35b5; }
        input, button {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            margin: 10px 0;
            border-radius: 6px;
        }
        input { border: 1px solid #ccc; }
        button {
            background: #6c45c5;
            color: white;
            border: none;
            cursor: pointer;
        }
        .message { text-align: center; color: #5b35b5; }
        a { display: block; text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>

        <?php if ($message !== ""): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="password" name="current_password"
                   placeholder="Current Password" required>

            <input type="password" name="new_password"
                   placeholder="New Password" required>

            <input type="password" name="confirm_password"
                   placeholder="Confirm New Password" required>

            <button type="submit">Update Password</button>
        </form>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
