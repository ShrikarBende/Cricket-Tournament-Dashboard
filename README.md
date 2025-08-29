# 🏏 Cricket Dashboard

Cricket Dashboard is a web-based tournament management system built with PHP and MySQL. It allows administrators to manage teams, players, schedules, and results, while users can view match updates, standings, and player details. This project is designed for local tournaments, clubs, and sports events.

## 📸 Screenshots

Here are screenshots of the dashboard in action:

**Main Login Page**
![Login Page](./ScreenShots/screenshot1.jpg)

**Admin Match Management**
![Edit Match Details](./ScreenShots/screenshot2.jpg)

**Match Scheduling Interface**
![Schedule Match](./ScreenShots/screenshot3.jpg)

**Tournament Standings**
![Tournament Standings](./ScreenShots/screenshot4.jpg)

**Match Results Dashboard**
![Match Results](./ScreenShots/screenshot5.jpg)

**Upcoming Matches View**
![Upcoming Matches](./ScreenShots/screenshot6.jpg)

## 🚀 Features

- 👤 **User Management:** Registration & login for users, admin login for management
- 🏏 **Team & Player Management:** Add/view teams and players
- 📅 **Match Scheduling:** Schedule upcoming matches and edit details
- 📝 **Results Management:** Enter and update match results
- 📊 **Standings & Results:** View results, leaderboards, and standings
- 🌐 **Public Dashboard:** Open access to schedules and results

## 🛠️ Tech Stack

- **Frontend:** PHP (server-side rendering)
- **Backend:** PHP with MySQL
- **Database:** MySQL (`db_connection.php` for DB setup)

## 📂 Project Structure

```
cricket_dashboard/
├── index.php                # Landing page
├── admin_login.php          # Admin authentication
├── admin_dashboard.php      # Admin panel
├── team_dashboard.php       # Team dashboard
├── user_login.php           # User login
├── user_register.php        # User registration
├── add_team.php             # Add new team
├── add_players.php          # Add new players
├── schedule_matches.php     # Match scheduling
├── enter_results.php        # Enter results
├── edit_match.php           # Edit match details
├── match_results.php        # View match results
├── view_standings.php       # View standings
├── view_upcoming_matches.php# Upcoming matches
├── view_teams.php           # Team list
├── view_players.php         # Player list
├── db_connection.php        # Database connection
└── logout.php               # Logout
```

## ⚡ Installation & Setup

### 1. Clone the repository

```bash
git clone https://github.com/ShrikarBende/cricket_dashboard.git
cd cricket_dashboard
```

### 2. Setup Database

1. Create a MySQL database (e.g., `cricket_db`).
2. Import the SQL file (if available) or create tables manually.

### 3. Configure Database

Update `db_connection.php` with your database credentials:

```php
$conn = mysqli_connect("localhost", "root", "", "cricket_db");
```

### 4. Run the Project

1. Place the project files in your `htdocs` (XAMPP) or `www` (WAMP) folder.
2. Start Apache & MySQL from your server control panel.
3. Open in your browser: `http://localhost/cricket_dashboard`

## 🎯 Use Cases

- College / School tournaments
- Local cricket leagues
- Club-level competitions
- Sports event management



## 🤝 Contributing

Contributions are welcome! Feel free to fork this repository, create a new branch, and submit a pull request.

## 📜 License

This project is open-source and available under the MIT License.
