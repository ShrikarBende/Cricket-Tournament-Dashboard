<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: user_login.php"); // Redirect to login if not logged in
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "cricket_tournament";

// Connect to database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the logged-in user's team details
$username = $_SESSION['username'];
$sql_user_team = "SELECT * FROM teams WHERE created_by='$username'";
$result_user_team = $conn->query($sql_user_team);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .container {
            background-color: #ffffff;
            color: #333;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.2);
            width: 420px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            margin-bottom: 25px;
            font-size: 26px;
            color: #222;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            background: linear-gradient(to right, #1d976c, #93f9b9);
            color: white;
        }

        .btn:hover {
            background: linear-gradient(to right, #11998e, #38ef7d);
            transform: scale(1.03);
        }

        .logout-btn {
            background: linear-gradient(to right, #f85032, #e73827);
        }

        .logout-btn:hover {
            background: linear-gradient(to right, #ff416c, #ff4b2b);
        }

        p {
            margin-top: 10px;
            font-size: 15px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <a href="add_team.php" class="btn">➕ Add Team</a>

        <?php
        if ($result_user_team->num_rows > 0) {
            echo '<a href="view_team.php" class="btn">👥 View My Team</a>';
            echo '<a href="add_players.php" class="btn">🎯 Add Players</a>';
        } else {
            echo "<p>No team added yet. Start by adding your team!</p>";
        }
        ?>

        <a href="logout.php" class="btn logout-btn">🚪 Logout</a>
    </div>

</body>
</html>
