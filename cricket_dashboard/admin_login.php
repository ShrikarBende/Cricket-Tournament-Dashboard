<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "cricket_tournament";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_user = $_POST['admin_user'];
    $admin_pass = $_POST['admin_pass'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $admin_user, $admin_pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['admin'] = $admin_user;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid admin credentials');</script>";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 400px;
            animation: fadeIn 0.6s ease-in-out;
            text-align: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border-radius: 10px;
            border: 1px solid #ccc;
        }

        .btn {
            padding: 14px;
            width: 100%;
            background: linear-gradient(to right, #1d976c, #93f9b9);
            color: white;
            border: none;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: linear-gradient(to right, #11998e, #38ef7d);
        }

        .back-btn {
            margin-top: 10px;
            background: linear-gradient(to right, #f7971e, #ffd200);
            color: #333;
        }

        .back-btn:hover {
            background: linear-gradient(to right, #ff8008, #ffc837);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🛠️ Admin Login</h2>
    <form method="POST">
        <input type="text" name="admin_user" placeholder="Admin Username" required>
        <input type="password" name="admin_pass" placeholder="Password" required>
        <button class="btn" type="submit">Login</button>
    </form>
    <a href="index.php"><button class="btn back-btn">⬅ Back to Home</button></a>
</div>

</body>
</html>
