<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "cricket_tournament";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get team id from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Team ID is missing.";
    exit();
}

$team_id = intval($_GET['id']);

// Get the team_name from the teams table using id
$team_sql = "SELECT team_name FROM teams WHERE id = ?";
$stmt = $conn->prepare($team_sql);
$stmt->bind_param("i", $team_id);
$stmt->execute();
$team_result = $stmt->get_result();

if ($team_result->num_rows === 0) {
    echo "Team not found.";
    exit();
}

$team_row = $team_result->fetch_assoc();
$team_name = $team_row['team_name'];

// Now fetch all players where team_name matches
$player_sql = "SELECT player_name, age, role, contact FROM players WHERE team_name = ?";
$stmt = $conn->prepare($player_sql);
$stmt->bind_param("s", $team_name);
$stmt->execute();
$player_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Players of <?php echo htmlspecialchars($team_name); ?></title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #43e97b, #38f9d7);
            padding: 30px;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 900px;
            margin: auto;
            animation: fadeIn 0.7s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 14px;
            text-align: center;
        }

        th {
            background-color: #43e97b;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background-color: #43e97b;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background-color: #2bdc8d;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>👥 Players of <?php echo htmlspecialchars($team_name); ?></h2>

    <table>
        <tr>
            <th>Player Name</th>
            <th>Age</th>
            <th>Role</th>
            <th>Contact</th>
        </tr>

        <?php
        if ($player_result && $player_result->num_rows > 0) {
            while ($player = $player_result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($player['player_name']) . "</td>
                        <td>" . htmlspecialchars($player['age']) . "</td>
                        <td>" . htmlspecialchars($player['role']) . "</td>
                        <td>" . htmlspecialchars($player['contact']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No players found for this team.</td></tr>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </table>

    <a href="view_teams.php" class="back-btn">⬅ Back to Teams</a>
</div>

</body>
</html>
