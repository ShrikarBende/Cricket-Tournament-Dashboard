<?php
// DB Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "cricket_tournament";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch completed matches
$sql = "SELECT * FROM matches WHERE status = 'Completed' ORDER BY match_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Match Results</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f9d423, #ff4e50);
            padding: 30px;
        }

        .container {
            max-width: 950px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #ff4e50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .back-btn {
            display: block;
            text-align: center;
            background-color: #ddd;
            padding: 12px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            width: 200px;
            margin: 0 auto;
        }

        .back-btn:hover {
            background-color: #bbb;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📊 Completed Match Results</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Match</th>
                <th>Date</th>
                <th>Time</th>
                <th>Team 1 Score</th>
                <th>Team 2 Score</th>
                <th>Winner</th>
                <th>Player of the Match</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['team1']) . " vs " . htmlspecialchars($row['team2']); ?></td>
                    <td><?php echo htmlspecialchars($row['match_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['match_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['team1_score']); ?></td>
                    <td><?php echo htmlspecialchars($row['team2_score']); ?></td>
                    <td><?php echo htmlspecialchars($row['winner']); ?></td>
                    <td><?php echo htmlspecialchars($row['player_of_match']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center; color: red;">No completed match results found yet.</p>
    <?php endif; ?>

    <a class="back-btn" href="public_view.php">⬅ Back to Public View</a>
</div>
</body>
</html>
