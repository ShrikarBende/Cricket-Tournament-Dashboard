<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "cricket_tournament";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username; // Store session
        header("Location: team_dashboard.php"); // Redirect to team dashboard
        exit();
    } else {
        echo "<script>alert('Invalid Username or Password');</script>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - Cricket Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #333;
            margin-bottom: 25px;
            font-size: 26px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #1d976c, #93f9b9);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn:hover {
            background: linear-gradient(to right, #11998e, #38ef7d);
            transform: scale(1.03);
        }

        .btn-back {
            background: linear-gradient(to right, #f7971e, #ffd200);
            color: #333;
            font-weight: 600;
        }

        .btn-back:hover {
            background: linear-gradient(to right, #ff8008, #ffc837);
            transform: scale(1.03);
        }

        .btn-register {
            background: linear-gradient(to right, #8e2de2, #4a00e0);
            color: #fff;
            font-weight: 600;
        }

        .btn-register:hover {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            transform: scale(1.03);
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }

        .link-buttons {
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>👤 User Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit" class="btn">Login</button>
        </form>

        <div class="link-buttons">
            <a href="index.php">
                <button class="btn btn-back">⬅ Back to Home</button>
            </a>
            <a href="user_register.php">
                <button class="btn btn-register">🆕 Create New Account</button>
            </a>
        </div>

        <div class="footer">© 2025 Cricket Tournament | Built with ❤️</div>
    </div>

</body>
</html>
