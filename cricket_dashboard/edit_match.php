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

// Update logic when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['match_id'])) {
    $match_id = $_POST['match_id'];
    $team1 = $_POST['team1'];
    $team2 = $_POST['team2'];
    $match_date = $_POST['match_date'];
    $match_time = $_POST['match_time'];
    $venue = $_POST['venue'];
    $status = $_POST['status'];

    $update = "UPDATE matches SET 
                team1 = '$team1', 
                team2 = '$team2', 
                match_date = '$match_date', 
                match_time = '$match_time', 
                venue = '$venue', 
                status = '$status' 
              WHERE id = $match_id";

    if ($conn->query($update) === TRUE) {
        $success = "Match details updated successfully!";
    } else {
        $error = "Error updating match: " . $conn->error;
    }
}

// Fetch all matches
$matches = $conn->query("SELECT * FROM matches");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Match Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #4facfe;
            color: white;
        }

        input, select {
            padding: 8px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .submit-btn {
            background: #4facfe;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #00c6ff;
        }

        .msg {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .back-btn {
            display: inline-block;
            margin-top: 15px;
            background-color: #4facfe;
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            border-radius: 10px;
        }

        .back-btn:hover {
            background-color: #00c6ff;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>🛠️ Edit Match Details</h2>

    <?php if (isset($success)) echo "<div class='msg' style='color: green;'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='msg' style='color: red;'>$error</div>"; ?>

    <?php
    if ($matches && $matches->num_rows > 0) {
        while ($match = $matches->fetch_assoc()) {
            ?>
            <form method="POST" style="margin-bottom: 30px;">
                <input type="hidden" name="match_id" value="<?php echo $match['id']; ?>">

                <table>
                    <tr>
                        <th>Team 1</th>
                        <th>Team 2</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Venue</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="team1" value="<?php echo htmlspecialchars($match['team1']); ?>"></td>
                        <td><input type="text" name="team2" value="<?php echo htmlspecialchars($match['team2']); ?>"></td>
                        <td><input type="date" name="match_date" value="<?php echo $match['match_date']; ?>"></td>
                        <td><input type="time" name="match_time" value="<?php echo $match['match_time']; ?>"></td>
                        <td><input type="text" name="venue" value="<?php echo htmlspecialchars($match['venue']); ?>"></td>
                        <td>
                            <select name="status">
                                <option value="Scheduled" <?php if ($match['status'] == 'Scheduled') echo 'selected'; ?>>Scheduled</option>
                                <option value="Completed" <?php if ($match['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                <option value="Postponed" <?php if ($match['status'] == 'Postponed') echo 'selected'; ?>>Postponed</option>
                                <option value="Cancelled" <?php if ($match['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                            </select>
                        </td>
                        <td><input class="submit-btn" type="submit" value="Update"></td>
                    </tr>
                </table>
            </form>
            <?php
        }
    } else {
        echo "<p>No matches scheduled yet.</p>";
    }

    $conn->close();
    ?>

    <a class="back-btn" href="admin_dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
