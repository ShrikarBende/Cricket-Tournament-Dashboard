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

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Teams</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
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
            background-color: #4facfe;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a.team-link {
            color: #007bff;
            font-weight: bold;
            text-decoration: none;
        }

        a.team-link:hover {
            text-decoration: underline;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background-color: #4facfe;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background-color: #00c6ff;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>📋 All Registered Teams</h2>

    <table>
        <tr>
            <th>Team Name (Click to View Players)</th>
            <th>Captain Name</th>
            <th>Captain Age</th>
            <th>Contact</th>
        </tr>

        <?php
        $sql = "SELECT id,team_name, captain_name, age, contact FROM teams";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td><a class='team-link' href='view_players.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['team_name']) . "</a></td>
                        <td>" . htmlspecialchars($row['captain_name']) . "</td>
                        <td>" . htmlspecialchars($row['age']) . "</td>
                        <td>" . htmlspecialchars($row['contact']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No teams found</td></tr>";
        }

        $conn->close();
        ?>
    </table>

    <a href="admin_dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
</div>

</body>
</html>
