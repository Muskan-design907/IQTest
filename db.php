<?php
// db.php - Database connection file
 
$host = 'localhost'; 
$dbname = 'dbubv3v79tmtar';
$username = 'ur9iyguafpilu';
$password = '51gssrtsv3ei';
 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Set error mode to Exception for debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error and stop script if connection fails
    die("Database connection failed: " . $e->getMessage());
}
?>
 
