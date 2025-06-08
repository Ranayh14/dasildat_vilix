<?php
// Database configuration
$host = 'localhost';
$dbname = 'apartment_price_prediction';
$username = 'root';
$password = '';

try {
    // Create connection
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if not exists
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $pdo->exec($sql);
    echo "Database created successfully<br>";

    // Select the database
    $pdo->exec("USE $dbname");

    // Create predictions table
    $sql = "CREATE TABLE IF NOT EXISTS predictions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        metro_minutes FLOAT NOT NULL,
        area FLOAT NOT NULL,
        living_area FLOAT NOT NULL,
        kitchen_area FLOAT NOT NULL,
        floor INT NOT NULL,
        num_floors INT NOT NULL,
        num_rooms INT NOT NULL,
        apartment_type VARCHAR(50) NOT NULL,
        renovation VARCHAR(10) NOT NULL,
        predicted_price FLOAT NOT NULL,
        actual_price FLOAT NULL,
        model_used VARCHAR(50) NOT NULL,
        prediction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'predictions' created successfully<br>";

    // Create model_metrics table for storing model performance metrics
    $sql = "CREATE TABLE IF NOT EXISTS model_metrics (
        id INT AUTO_INCREMENT PRIMARY KEY,
        model_name VARCHAR(50) NOT NULL,
        mse FLOAT NOT NULL,
        mae FLOAT NOT NULL,
        r2_score FLOAT NOT NULL,
        update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table 'model_metrics' created successfully<br>";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 