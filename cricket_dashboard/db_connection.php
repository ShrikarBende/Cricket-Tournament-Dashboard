<?php
$conn = new mysqli("localhost", "root", "", "cricket_tournament");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
