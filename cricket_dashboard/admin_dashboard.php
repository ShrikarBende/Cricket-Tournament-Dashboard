<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 500px;
            text-align: center;
            animation: fadeIn 0.7s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #333;
            margin-bottom: 25px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            background: linear-gradient(to right, #1d976c, #93f9b9);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
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
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome Admin 👑</h2>
    
    <a href="view_teams.php" class="btn">📋 View All Teams & Players</a>
    <a href="schedule_matches.php" class="btn">🗓️ Schedule Matches</a>
    <a href="edit_match.php" class="btn">🧾 Edit Match Details</a>
    <a href="enter_results.php" class="btn">🏏 Enter Match Results</a>
    <a href="view_standings.php" class="btn">🏆 View Standings</a>
    <a href="index.php" class="btn logout-btn">🚪 Logout</a>
</div>

</body>
</html>
