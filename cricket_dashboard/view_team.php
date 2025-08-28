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

$user_username = $_SESSION['username'];
$sql_user_teams = "SELECT team_name FROM teams WHERE created_by='$user_username'";
$result_user_teams = $conn->query($sql_user_teams);

$players = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['team_name'])) {
    $team_name = $_POST['team_name'];
    $sql_players = "SELECT * FROM players WHERE team_name='$team_name'";
    $result_players = $conn->query($sql_players);
    if ($result_players->num_rows > 0) {
        while ($row = $result_players->fetch_assoc()) {
            $players[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Team Players</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
            color: #fff;
        }

        .container {
            background-color: #fff;
            color: #333;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
        }

        select {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
            font-size: 16px;
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
            margin-top: 10px;
            transition: 0.3s ease;
        }

        .btn:hover {
            background: linear-gradient(to right, #11998e, #38ef7d);
            transform: scale(1.03);
        }

        .btn-secondary {
            background: linear-gradient(to right, #00b09b, #96c93d);
            margin-top: 20px;
        }

        .btn-secondary:hover {
            background: linear-gradient(to right, #56ab2f, #a8e063);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            padding: 14px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            table, th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>📋 View Team Players</h2>

        <form method="POST" action="view_team.php">
            <select name="team_name" required>
                <option value="">Select Your Team</option>
                <?php while ($row = $result_user_teams->fetch_assoc()) { ?>
                    <option value="<?php echo $row['team_name']; ?>"><?php echo $row['team_name']; ?></option>
                <?php } ?>
            </select>
            <button type="submit" class="btn">View Players</button>
        </form>

        <?php if (!empty($players)) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Player Name</th>
                        <th>Age</th>
                        <th>Role</th>
                        <th>Contact</th>
                        <th>Captain</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $player) { ?>
                        <tr>
                            <td><?php echo $player['player_name']; ?></td>
                            <td><?php echo $player['age']; ?></td>
                            <td><?php echo $player['role']; ?></td>
                            <td><?php echo $player['contact']; ?></td>
                            <td><?php echo $player['captain'] == 1 ? 'Yes' : 'No'; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>

        <a href="team_dashboard.php"><button class="btn btn-secondary">⬅ Back to Dashboard</button></a>
    </div>

</body>
</html>
