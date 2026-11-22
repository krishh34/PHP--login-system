
<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = mysqli_prepare($conn, "SELECT name, email, created_at FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
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
        .profile-card {
            background: white;
            width: 350px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px #0001;
        }
        h2 { text-align: center; color: #5b35b5; }
        .detail { margin: 20px 0; color: #333; }
        .detail strong { display: block; margin-bottom: 6px; }
        a {
            display: block;
            text-align: center;
            background: #6c45c5;
            color: white;
            padding: 12px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <h2>My Profile</h2>

        <div class="detail">
            <strong>Name</strong>
            <?= htmlspecialchars($user["name"]) ?>
        </div>

        <div class="detail">
            <strong>Email</strong>
            <?= htmlspecialchars($user["email"]) ?>
        </div>

        <div class="detail">
            <strong>Account Created</strong>
            <?= htmlspecialchars($user["created_at"]) ?>
        </div>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
