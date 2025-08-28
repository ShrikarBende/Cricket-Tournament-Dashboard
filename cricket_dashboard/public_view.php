<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public View - Cricket Tournament</title>
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
            width: 420px;
            animation: fadeIn 1s ease-in-out;
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

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            background: linear-gradient(to right, #1d976c, #93f9b9);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: linear-gradient(to right, #11998e, #38ef7d);
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
        <h2>🌐 Public Dashboard</h2>
        
        <a href="view_upcoming_matches.php" class="btn">🔍 View Upcoming Match Schedules</a>
        <a href="view_standings1.php" class="btn">🏆 View Live Points Table</a>
        <a href="match_results.php" class="btn">📈 See Match Results</a>
        <a href="index.php" class="btn" style="background: linear-gradient(to right, #ff416c, #ff4b2b); margin-top: 20px;">🚪 Logout</a>
        
        <div class="footer">© 2025 Cricket Tournament | Made with ❤️ for Fans</div>
    </div>

</body>
</html>
