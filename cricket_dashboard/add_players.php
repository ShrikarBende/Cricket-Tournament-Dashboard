<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "cricket_tournament";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$sql_teams = "SELECT team_name FROM teams WHERE created_by='$username'";
$result_teams = $conn->query($sql_teams);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $player_name = $_POST['player_name'];
    $age = $_POST['age'];
    $role = $_POST['role'];
    $contact = $_POST['contact'];
    $team_name = $_POST['team_name'];
    $captain = isset($_POST['captain']) ? 1 : 0;

    $sql_insert = "INSERT INTO players (player_name, age, role, contact, team_name, captain) 
                   VALUES ('$player_name', '$age', '$role', '$contact', '$team_name', '$captain')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>alert('Player added successfully!'); window.location.href='team_dashboard.php';</script>";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Players</title>
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
            background-color: #fff;
            color: #333;
            padding: 35px 30px;
            border-radius: 20px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.2);
            width: 450px;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 26px;
        }

        input, select {
            width: 100%;
            padding: 10px 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .checkbox-container input {
            margin-right: 8px;
            transform: scale(1.2);
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #1d976c, #93f9b9);
            color: white;
            font-weight: bold;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .btn:hover {
            background: linear-gradient(to right, #11998e, #38ef7d);
            transform: scale(1.03);
        }

        .btn-secondary {
            background: linear-gradient(to right, #00b09b, #96c93d);
        }

        .btn-secondary:hover {
            background: linear-gradient(to right, #56ab2f, #a8e063);
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>➕ Add Player</h2>
        <form method="POST" action="add_players.php">
            <input type="text" name="player_name" placeholder="Player Name" required>
            <input type="number" name="age" placeholder="Age" required>
            
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="Batsman">Batsman</option>
                <option value="Bowler">Bowler</option>
                <option value="All-rounder">All-rounder</option>
                <option value="Wicketkeeper">Wicketkeeper</option>
            </select>
            
            <input type="text" name="contact" placeholder="Contact Number" maxlength="10" required>

            <select name="team_name" required>
                <option value="">Select Team</option>
                <?php while ($row = $result_teams->fetch_assoc()) { ?>
                    <option value="<?php echo $row['team_name']; ?>"><?php echo $row['team_name']; ?></option>
                <?php } ?>
            </select>

            <div class="checkbox-container">
                <input type="checkbox" name="captain" id="captain">
                <label for="captain">Mark as Captain</label>
            </div>

            <button type="submit" class="btn">Add Player</button>
        </form>
        <a href="team_dashboard.php"><button class="btn btn-secondary">⬅ Back to Dashboard</button></a>
    </div>

</body>
</html>
