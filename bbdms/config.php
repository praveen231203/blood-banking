<?php
$host = "localhost";  // Change this if your database is hosted remotely
$dbname = "contactdb1";  // Your database name
$username = "root";  // Default for XAMPP (change if needed)
$password = "";  // Default for XAMPP (leave empty, change if needed)

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
