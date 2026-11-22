
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
        }

        header {
            background: #764ba2;
            color: white;
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard {
            padding: 50px 8%;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-top: 25px;
        }

        .logout {
            background: white;
            color: #764ba2;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <header>
        <h2>My Dashboard</h2>
        <a href="logout.php" class="logout">Logout</a>
        <a href="profile.php">My Profile</a>
        <a href="change_password.php">Change Password</a>
        <a href="edit_profile.php">Edit Profile</a>
    </header>

    <div class="dashboard">

        <h1>
            Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!
        </h1>

        <div class="card">
            <h2>Dashboard Overview</h2>
            <p>You are successfully logged in.</p>
            <p>Your User ID: <?php echo (int)$_SESSION["user_id"]; ?></p>
        </div>

    </div>

</body>
</html>
