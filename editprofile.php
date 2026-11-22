
<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION["user_id"];
$message = "";

$stmt = mysqli_prepare($conn, "SELECT name FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);

    if ($name === "") {
        $message = "Name cannot be empty.";
    } else {
        $update = mysqli_prepare($conn, "UPDATE users SET name = ? WHERE id = ?");
        mysqli_stmt_bind_param($update, "si", $name, $id);

        if (mysqli_stmt_execute($update)) {
            $_SESSION["user_name"] = $name;
            $message = "Profile updated successfully!";
            $user["name"] = $name;
        } else {
            $message = "Unable to update profile.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
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
        <h2>Edit Profile</h2>

        <?php if ($message !== ""): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <input
                type="text"
                name="name"
                value="<?= htmlspecialchars($user["name"]) ?>"
                placeholder="Enter your name"
                maxlength="100"
                required
            >
            <button type="submit">Save Changes</button>
        </form>

        <a href="profile.php">Back to Profile</a>
    </div>
</body>
</html>
