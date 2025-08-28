<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// DB connection
$conn = new mysqli("localhost", "root", "", "cricket_tournament");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all teams
$teamsQuery = "SELECT team_name FROM teams";
$teamsResult = $conn->query($teamsQuery);

$standings = [];

if ($teamsResult && $teamsResult->num_rows > 0) {
    while ($team = $teamsResult->fetch_assoc()) {
        $teamName = $team['team_name'];

        // Count total matches played
        $matchesPlayedQuery = "SELECT COUNT(*) as total FROM matches 
                               WHERE status = 'Completed' AND 
                               (team1 = '$teamName' OR team2 = '$teamName')";
        $matchesPlayed = $conn->query($matchesPlayedQuery)->fetch_assoc()['total'];

        // Count wins
        $winsQuery = "SELECT COUNT(*) as wins FROM matches 
                      WHERE status = 'Completed' AND winner = '$teamName'";
        $wins = $conn->query($winsQuery)->fetch_assoc()['wins'];

        // Calculate losses
        $losses = $matchesPlayed - $wins;

        // Store in array
        $standings[] = [
            'team_name' => $teamName,
            'matches_played' => $matchesPlayed,
            'wins' => $wins,
            'losses' => $losses,
            'win_ratio' => $matchesPlayed > 0 ? round($wins / $matchesPlayed, 2) : 0
        ];
    }
}

// Sort by number of wins (descending)
usort($standings, function($a, $b) {
    return $b['wins'] - $a['wins'];
});
?>

<!DOCTYPE html>
<html>
<head>
    <title>Team Standings</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            padding: 30px;
        }
        .container {
            background: #fff;
            padding: 30px;
            max-width: 800px;
            margin: auto;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background: #43cea2;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .back-btn {
            margin-top: 25px;
            display: block;
            width: 200px;
            padding: 12px;
            text-align: center;
            background: #185a9d;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            margin-left: auto;
            margin-right: auto;
        }
        .back-btn:hover {
            background-color: #0b3c74;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📊 Tournament Standings</h2>

    <table>
        <tr>
            <th>Rank</th>
            <th>Team Name</th>
            <th>Matches Played</th>
            <th>Wins</th>
            <th>Losses</th>
            <th>Win Ratio</th>
        </tr>
        <?php
        $rank = 1;
        foreach ($standings as $team) {
            echo "<tr>
                    <td>$rank</td>
                    <td>{$team['team_name']}</td>
                    <td>{$team['matches_played']}</td>
                    <td>{$team['wins']}</td>
                    <td>{$team['losses']}</td>
                    <td>{$team['win_ratio']}</td>
                  </tr>";
            $rank++;
        }
        ?>
    </table>

    <a href="admin_dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
</div>
</body>
</html>
