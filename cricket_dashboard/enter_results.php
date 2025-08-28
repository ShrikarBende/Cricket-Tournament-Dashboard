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

// Handle result submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['match_id'])) {
    $match_id = $_POST['match_id'];
    $team1_score = $_POST['team1_score'];
    $team2_score = $_POST['team2_score'];
    $winner = $_POST['winner'];
    $player_of_match = $_POST['player_of_match'];

    $update = "UPDATE matches SET 
                team1_score = ?, 
                team2_score = ?, 
                winner = ?, 
                player_of_match = ?, 
                status = 'Completed' 
               WHERE id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("ssssi", $team1_score, $team2_score, $winner, $player_of_match, $match_id);

    if ($stmt->execute()) {
        $success = "✅ Match results updated successfully!";
    } else {
        $error = "❌ Error updating match results.";
    }
}

// Get all scheduled matches
$sql = "SELECT * FROM matches WHERE status = 'Scheduled'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter Match Results</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            padding: 30px;
        }

        .container {
            max-width: 700px;
            background: #fff;
            margin: auto;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        select, input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }

        .btn {
            background-color: #4facfe;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #00c6ff;
        }

        .message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            background-color: #ccc;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🏆 Enter Match Results</h2>

    <?php if (isset($success)) echo "<p class='message' style='color:green;'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p class='message' style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <div class="form-group">
            <label for="match_id">Select Match</label>
            <select name="match_id" id="match_id" required>
                <option value="">-- Choose a Match --</option>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($match = $result->fetch_assoc()) {
                        echo "<option value='{$match['id']}'>
                              {$match['team1']} vs {$match['team2']} on {$match['match_date']} at {$match['match_time']}
                              </option>";
                    }
                } else {
                    echo "<option disabled>No scheduled matches</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="team1_score">Team 1 Score</label>
            <input type="text" name="team1_score" placeholder="e.g., 150/7 (20 overs)" required>
        </div>

        <div class="form-group">
            <label for="team2_score">Team 2 Score</label>
            <input type="text" name="team2_score" placeholder="e.g., 148/8 (20 overs)" required>
        </div>

        <div class="form-group">
            <label for="winner">Winner</label>
            <input type="text" name="winner" placeholder="Enter Winning Team Name" required>
        </div>

        <div class="form-group">
            <label for="player_of_match">Player of the Match</label>
            <input type="text" name="player_of_match" placeholder="e.g., Rohit Sharma">
        </div>

        <button type="submit" class="btn">Submit Result</button>
    </form>

    <a class="back-btn" href="admin_dashboard.php">⬅ Back to Dashboard</a>
</div>
</body>
</html>
