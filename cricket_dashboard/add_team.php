<?php
session_start();
require 'db_connection.php'; // Ensure this file contains database connection details

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team_name = $_POST['team_name'];
    $captain_name = $_POST['captain_name'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];
    $created_by = $_SESSION['username'];

    if (empty($team_name) || empty($captain_name) || empty($age) || empty($contact)) {
        $message = "All fields are required!";
    } elseif (!is_numeric($age) || $age <= 0) {
        $message = "Invalid age!";
    } elseif (!preg_match('/^[0-9]{10}$/', $contact)) {
        $message = "Invalid contact number!";
    } else {
        $sql = "INSERT INTO teams (team_name, captain_name, age, contact, created_by) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiss", $team_name, $captain_name, $age, $contact, $created_by);
        
        if ($stmt->execute()) {
            header("Location: team_dashboard.php");
            exit();
        } else {
            $message = "Error adding team: " . $conn->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Team</title>
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
            padding: 40px 30px;
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
            margin-bottom: 25px;
            font-size: 26px;
            text-align: center;
        }

        form label {
            font-weight: 600;
            margin-top: 10px;
            display: block;
            font-size: 14px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 15px;
        }

        .btn-primary {
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
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #11998e, #38ef7d);
            transform: scale(1.03);
        }

        .message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            text-align: center;
            font-weight: bold;
            transition: 0.2s;
        }

        .back-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>➕ Add a New Team</h2>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

        <form method="POST" action="add_team.php">
            <label for="team_name">Team Name:</label>
            <input type="text" name="team_name" id="team_name" required>

            <label for="captain_name">Captain Name:</label>
            <input type="text" name="captain_name" id="captain_name" required>

            <label for="age">Age:</label>
            <input type="number" name="age" id="age" min="1" required>

            <label for="contact">Contact Number:</label>
            <input type="text" name="contact" id="contact" maxlength="10" required>

            <button type="submit" class="btn-primary">Add Team</button>
        </form>

        <a href="team_dashboard.php" class="back-link">⬅ Back to Dashboard</a>
    </div>

</body>
</html>
