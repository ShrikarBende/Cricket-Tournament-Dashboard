<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cricket_tournament";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];

    // Check if username already exists in users1 table
    $check_sql = "SELECT * FROM users1 WHERE username='$new_username'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username already exists! Please choose another one.');</script>";
    } else {
        $insert_sql = "INSERT INTO users1 (username, password) VALUES ('$new_username', '$new_password')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('Registration successful! You can now login.'); window.location.href='user_login.php';</script>";
        } else {
            echo "<script>alert('Error: Could not register user.');</script>";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Cricket Dashboard</title>
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

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>📝 Create New Account</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Choose Username" required>
            <input type="password" name="password" placeholder="Choose Password" required>
            <button type="submit" class="btn">Register</button>
        </form>

        <!-- Back to Login Button -->
        <a href="user_login.php">
            <button class="btn btn-back">⬅ Back to Login</button>
        </a>

        <div class="footer">© 2025 Cricket Tournament | Built with ❤️</div>
    </div>

</body>
</html>
