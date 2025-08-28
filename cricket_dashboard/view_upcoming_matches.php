<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "cricket_tournament";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch upcoming/scheduled matches (status = 'Scheduled' or 'Upcoming')
$query = "SELECT * FROM matches WHERE status = 'Scheduled' OR status = 'Upcoming' ORDER BY match_date, match_time";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upcoming Matches</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #667eea, #764ba2);
            padding: 40px;
            color: #333;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 14px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #667eea;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .back-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background-color: #764ba2;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background-color: #5a3f8c;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📅 Upcoming Matches</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Match ID</th>
                <th>Team 1</th>
                <th>Team 2</th>
                <th>Date</th>
                <th>Time</th>
                <th>Venue</th>
                <th>Status</th>
            </tr>
            <?php while ($match = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $match['id'] ?></td>
                    <td><?= htmlspecialchars($match['team1']) ?></td>
                    <td><?= htmlspecialchars($match['team2']) ?></td>
                    <td><?= $match['match_date'] ?></td>
                    <td><?= $match['match_time'] ?></td>
                    <td><?= htmlspecialchars($match['venue']) ?></td>
                    <td><?= $match['status'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No upcoming matches scheduled at the moment.</p>
    <?php endif; ?>

    <div style="text-align: center;">
        <a class="back-btn" href="public_view.php">⬅ Back to Public Dashboard</a>
    </div>
</div>
</body>
</html>

<?php $conn->close(); ?>
