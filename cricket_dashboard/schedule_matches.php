<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "cricket_tournament";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle match scheduling
$success = $error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $team1 = $_POST['team1'];
    $team2 = $_POST['team2'];
    $match_date = $_POST['match_date'];
    $match_time = $_POST['match_time'];
    $venue = $_POST['venue'];

    if ($team1 !== $team2) {
        $stmt = $conn->prepare("INSERT INTO matches (team1, team2, match_date, match_time, venue) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $team1, $team2, $match_date, $match_time, $venue);
        if ($stmt->execute()) {
            $success = "Match scheduled successfully!";
        } else {
            $error = "Failed to schedule match.";
        }
    } else {
        $error = "Team 1 and Team 2 must be different.";
    }
}

// Fetch teams
$teams = [];
$result = $conn->query("SELECT team_name FROM teams");
while ($row = $result->fetch_assoc()) {
    $teams[] = $row['team_name'];
}

// Fetch scheduled matches
$matches_result = $conn->query("SELECT * FROM matches ORDER BY match_date, match_time");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Matches</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #43e97b, #38f9d7);
            padding: 40px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        form label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        .btn {
            background-color: #43e97b;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            margin-top: 20px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: #2bdc8d;
        }

        .msg {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
            color: green;
        }

        .error {
            text-align: center;
            color: red;
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #43e97b;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
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
    <h2>📅 Schedule a Match</h2>

    <?php if (!empty($success)) echo "<div class='msg'>$success</div>"; ?>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">
        <label>Team 1</label>
        <select name="team1" required>
            <option value="">-- Select Team 1 --</option>
            <?php foreach ($teams as $team): ?>
                <option value="<?= htmlspecialchars($team) ?>"><?= htmlspecialchars($team) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Team 2</label>
        <select name="team2" required>
            <option value="">-- Select Team 2 --</option>
            <?php foreach ($teams as $team): ?>
                <option value="<?= htmlspecialchars($team) ?>"><?= htmlspecialchars($team) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Match Date</label>
        <input type="date" name="match_date" required>

        <label>Match Time</label>
        <input type="time" name="match_time" required>

        <label>Venue</label>
        <input type="text" name="venue" required placeholder="Enter match venue">

        <button type="submit" class="btn">➕ Schedule Match</button>
    </form>

    <h2>📋 Scheduled Matches</h2>
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
        <?php
        if ($matches_result && $matches_result->num_rows > 0) {
            while ($match = $matches_result->fetch_assoc()) {
                echo "<tr>
                    <td>{$match['id']}</td>
                    <td>" . htmlspecialchars($match['team1']) . "</td>
                    <td>" . htmlspecialchars($match['team2']) . "</td>
                    <td>{$match['match_date']}</td>
                    <td>{$match['match_time']}</td>
                    <td>" . htmlspecialchars($match['venue']) . "</td>
                    <td>{$match['status']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No matches scheduled yet.</td></tr>";
        }
        ?>
    </table>

    <a class="back-btn" href="admin_dashboard.php">⬅ Back to Dashboard</a>
</div>
</body>
</html>
